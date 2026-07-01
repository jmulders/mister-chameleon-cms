<?php

namespace MisterChameleon\AdaptiveSlots\Tags;

use Illuminate\Support\Facades\Http;
use Statamic\Tags\Tags;

/**
 * Mister Chameleon — server-side adaptive slots.
 *
 * Usage in an Antlers template:
 *
 *   {{ mc:slot type="hero" }}
 *     <p class="eyebrow">{{ tag ?? 'Adaptive websites' }}</p>
 *     <h1>{{ title ?? 'Your website, personalised.' }}</h1>
 *     <p>{{ subtitle ?? 'The right message for every visitor.' }}</p>
 *     <a href="{{ cta_href ?? '/signup' }}">{{ cta_label ?? 'Start free' }}</a>
 *   {{ /mc:slot }}
 *
 * The tag fetches the visitor's personalised variant from the platform's
 * /api/snippet/decide endpoint (once per request), and exposes each field as a
 * variable inside the pair. Authors write their CMS/default copy with the `??`
 * fallback operator, so bots, no-JS visitors, and any request made while the
 * platform is unavailable render the default — fully server-side, SEO-safe,
 * with no client-side swap or flash.
 *
 * Variable names per slot type (the platform's decision contract, prefix
 * stripped and dashes turned into underscores):
 *   hero        → tag, title, subtitle, cta_label, cta_href, cta2_label, cta2_href
 *   proof       → title, items[] (title, text)
 *   cta         → title, text, cta_label, cta_href
 *   feature     → title, subtitle, items[] (title, body)
 *   conversion  → title, text, cta_label, cta_href, urgency_label
 *   notification→ message, severity, cta_label, cta_href, dismissible
 */
class MisterChameleon extends Tags
{
    /** Templates address this addon as {{ mc:... }}. */
    protected static $handle = 'mc';

    /**
     * Per-request cache of the decision (slot map). The decide endpoint returns
     * every slot for the page in one call, so we fetch it at most once per
     * request and slice it per {{ mc:slot }} usage.
     */
    protected static ?array $decision = null;

    /**
     * {{ mc:slot type="hero" }} ... {{ /mc:slot }}
     */
    public function slot()
    {
        $type  = (string) $this->params->get('type', 'hero');
        $slots = $this->resolveSlots();

        $vars  = ['slot_type' => $type];
        $items = [];

        $prefix = $type.'-';
        foreach ($slots as $key => $value) {
            if (! str_starts_with($key, $prefix)) {
                continue;
            }
            $rest = substr($key, strlen($prefix)); // e.g. "cta-label" or "item-0-title"

            // Item-array fields: proof/feature return "item-{n}-{field}".
            if (preg_match('/^item-(\d+)-(.+)$/', $rest, $m)) {
                $idx   = (int) $m[1];
                $field = str_replace('-', '_', $m[2]);
                $items[$idx] ??= [];
                $items[$idx][$field] = $value;
                continue;
            }

            // Flat field: "cta-label" → "cta_label".
            $vars[str_replace('-', '_', $rest)] = $value;
        }

        $matched = count($vars) > 1; // more than just slot_type

        if (! empty($items)) {
            ksort($items);
            $vars['items'] = array_values($items);
            $matched = true;
        }

        // Apply author-provided fallbacks for any field the platform did NOT
        // personalise. Passed as `fallback_<var>` params — this is how the
        // page-builder block hands its CMS-authored content to the tag without
        // the variable-name collisions you'd get from the surrounding scope.
        foreach ($this->params->all() as $pKey => $pVal) {
            if (! str_starts_with((string) $pKey, 'fallback_')) {
                continue;
            }
            $var = substr((string) $pKey, strlen('fallback_'));
            $missing = ! isset($vars[$var]) || $vars[$var] === null || $vars[$var] === '';
            if ($missing && $pVal !== null && $pVal !== '') {
                $vars[$var] = $pVal;
            }
        }

        // Did any personalised value come back for this slot (before fallbacks)?
        $vars['personalised'] = $matched;

        return $this->parse($vars);
    }

    /**
     * Fetch the slot decision from the platform, once per request. Fails open:
     * on any error / timeout / missing key it returns an empty map so the
     * author's inline fallbacks render.
     */
    protected function resolveSlots(): array
    {
        if (static::$decision !== null) {
            return static::$decision;
        }

        $siteKey = config('mister-chameleon.site_key');
        if (empty($siteKey)) {
            return static::$decision = [];
        }

        $base    = rtrim((string) config('mister-chameleon.platform_url', 'https://app.misterchameleon.com'), '/');
        $timeout = (int) config('mister-chameleon.timeout', 2);
        $ttl     = (int) config('mister-chameleon.cache_ttl', 0);
        $request = request();

        $context = array_filter([
            'path'         => '/'.ltrim($request->path(), '/'),
            'referrer'     => $request->headers->get('referer'),
            'utm_source'   => $request->query('utm_source'),
            'utm_medium'   => $request->query('utm_medium'),
            'utm_campaign' => $request->query('utm_campaign'),
            'sessionId'    => $request->cookie('mc_session_id'),
            'locale'       => str_replace('_', '-', app()->getLocale()),
        ], static fn ($v) => $v !== null && $v !== '');

        // Fetch closure — fails open (empty map → author fallbacks render).
        $fetch = static function () use ($base, $siteKey, $context, $timeout): array {
            try {
                $response = Http::timeout($timeout)
                    ->acceptJson()
                    ->post($base.'/api/snippet/decide', [
                        'siteKey' => $siteKey,
                        'context' => $context,
                    ]);

                if ($response->successful()) {
                    return (array) ($response->json('slots') ?? []);
                }
            } catch (\Throwable $e) {
                // Fail open.
            }

            return [];
        };

        // Optional short-lived cache. The cache key includes the full context
        // (path, utm, sessionId, locale, ...), and sessionId is per visitor, so
        // one visitor's personalisation is never served to another.
        if ($ttl > 0) {
            $key = 'mc_slots_'.md5($siteKey.'|'.json_encode($context));

            return static::$decision = \Illuminate\Support\Facades\Cache::remember($key, $ttl, $fetch);
        }

        return static::$decision = $fetch();
    }
}

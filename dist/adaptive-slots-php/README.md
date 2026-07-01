# Mister Chameleon — Adaptive Slots for Statamic (server-side / PHP edition)

A real Statamic addon that adds per-visitor personalisation to **any Statamic
site** via a `{{ mc:slot }}` Antlers tag. The tag calls Mister Chameleon's
decision API **server-side** at render time, so the personalised content is in
the initial HTML — **no client-side swap, no flash, fully SEO-personalised.**

This is the recommended edition for production. (A lighter client-side/snippet
edition also exists — see `../adaptive-slots/` — which swaps content in the
browser and requires no PHP.)

## Why the server-side edition

| | Client-side (snippet) | Server-side (this addon) |
|---|---|---|
| Personalised content in initial HTML | No (swapped in browser) | **Yes** |
| Flash of default content | Possible | **None** |
| SEO sees personalised copy | No (sees fallback) | **Yes** |
| Multiple slots of the same type per page | No | **Yes** |
| Requires PHP addon install | No | Yes |
| Adds a server-side API call per page | No | Yes (short timeout, fails open) |

## Install

### 1. Add the package

If you publish it to a registry (or a private Composer repo):

```bash
composer require misterchameleon/adaptive-slots
```

Or install from a local path — add to the site's `composer.json`:

```json
"repositories": [
    { "type": "path", "url": "./addons/adaptive-slots" }
],
```

then `composer require misterchameleon/adaptive-slots:*`.

Statamic auto-discovers the addon (no manual provider registration needed).

### 2. Configure your site key

```bash
php artisan vendor:publish --tag=mister-chameleon-config
```

Then set in `.env`:

```
MC_SITE_KEY=sk_live_your_key_here
# optional:
MC_PLATFORM_URL=https://app.misterchameleon.com
MC_DECIDE_TIMEOUT=2
MC_DECIDE_CACHE_TTL=0      # seconds; 0 = off. e.g. 30-60 to absorb reloads.
```

Get the site key from the Mister Chameleon dashboard (Setup → Snippet), and make
sure this site's domain is registered as a site there so the decision engine
knows its variants/rules.

## Usage

Wrap your CMS/default content in `{{ mc:slot }}` and reference the personalised
fields with the `??` fallback operator:

```antlers
{{ mc:slot type="hero" }}
  <p class="eyebrow">{{ tag ?? 'Adaptive websites, without the complexity' }}</p>
  <h1>{{ title ?? 'Your website, personalised for every visitor.' }}</h1>
  <p>{{ subtitle ?? 'The right message at the right moment.' }}</p>
  <a class="btn" href="{{ cta_href ?? '/signup' }}">{{ cta_label ?? 'Start free' }}</a>
{{ /mc:slot }}
```

Combine with your Statamic content — e.g. author defaults in a page-builder
block and pass them as the fallback:

```antlers
{{ mc:slot type="cta" }}
  <h2>{{ title ?? cms_heading }}</h2>
  <p>{{ text ?? cms_body }}</p>
  <a href="{{ cta_href ?? cms_cta_url }}">{{ cta_label ?? cms_cta_label }}</a>
{{ /mc:slot }}
```

### Available variables per slot type

| Slot type    | Variables                                                              |
|--------------|-----------------------------------------------------------------------|
| `hero`       | `tag`, `title`, `subtitle`, `cta_label`, `cta_href`, `cta2_label`, `cta2_href` |
| `proof`      | `title`, `items` (each: `title`, `text`)                              |
| `cta`        | `title`, `text`, `cta_label`, `cta_href`                             |
| `feature`    | `title`, `subtitle`, `items` (each: `title`, `body`)                 |
| `conversion` | `title`, `text`, `cta_label`, `cta_href`, `urgency_label`            |
| `notification`| `message`, `severity`, `cta_label`, `cta_href`, `dismissible`        |

Plus `slot_type` and `personalised` (boolean — true when the platform returned a
value for this slot) are always available.

Looping item arrays (proof / feature):

```antlers
{{ mc:slot type="proof" }}
  <h2>{{ title ?? 'Trusted by teams worldwide' }}</h2>
  {{ items }}
    <blockquote>{{ text }}<cite>{{ title }}</cite></blockquote>
  {{ /items }}
{{ /mc:slot }}
```

## Native page-builder block (optional)

Prefer editable blocks over hand-written tags? This bundle also ships the
**Context Slot** page-builder block, rendered server-side through the same tag —
so authors get a proper CP editing UI and you still get SSR personalisation.

```
cp fieldsets/mc_context_slot.yaml     resources/fieldsets/
cp views/mc_context_slot.antlers.html resources/views/partials/
```

Add the set to your Replicator/Bard blueprint:

```yaml
sets:
  mc_context_slot:
    display: 'Adaptive slot (Mister Chameleon)'
    icon: light-bulb
    fields:
      - import: mc_context_slot
```

Dispatch it in your page-builder loop:

```antlers
{{ page_blocks }}
  {{ if type == 'context_slot' }}
    {{ partial:mc_context_slot }}
  {{ else }}
    {{# ...your existing block types... #}}
  {{ /if }}
{{ /page_blocks }}
```

The partial passes each CMS field to `{{ mc:slot }}` as a `fallback_*` param, so
the platform's personalised value wins when present and the author's content
renders otherwise. Unlike the client-side edition, there is **no one-slot-per-type
limit** here — you can drop as many Context Slots on a page as you like.

## How it works

1. On the first `{{ mc:slot }}` of a request, the tag builds the visitor context
   (path, referrer, UTM, `mc_session_id` cookie, locale) and `POST`s it to
   `{platform}/api/snippet/decide` with your site key. The response (all slots
   for the page) is cached for the rest of the request.
2. Each `{{ mc:slot type="…" }}` slices its fields out of that response and
   exposes them as variables. Missing values fall back to your `??` defaults.

## Notes & limits

- **Fails open.** Missing key, timeout, or platform error → your fallback content
  renders. The timeout (default 2s) bounds the worst case.
- **Latency.** This adds one server-side API call per page (cached per request).
  Keep the timeout tight; the platform's decide endpoint is lightweight.
- **Returning-visitor signals** rely on the `mc_session_id` cookie. If this site
  doesn't already set it, run the client snippet alongside (it manages the
  session id/cookies), or set the cookie yourself.
- **Media** is not personalised by this tag (copy + links only), matching the
  platform's slot contract.

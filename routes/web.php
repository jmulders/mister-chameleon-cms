<?php

use App\Http\Controllers\CalendarController;
use Illuminate\Support\Facades\Route;
use Statamic\Facades\Entry;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Facades\Statamic\CP\LivePreview;

// ── Live Preview bridge ──────────────────────────────────────────────────────
//
// Statamic's native Live Preview iframe loads this route (configured as the
// `pages` collection preview target in content/collections/pages.yaml).
//
// Why a bridge is needed: the site's url is the absolute Vercel domain, so
// Statamic would otherwise iframe Vercel directly using its *native*
// ?live-preview&token mechanism — which the Next.js app doesn't understand, so
// it would render the SAVED page instead of the in-progress edits.
//
// Instead, this same-origin route retrieves the unsaved entry via the
// live-preview token (LivePreview::item), POSTs its draft page_blocks to the
// Next.js draft API, and points an inner iframe at the Vercel site with
// ?_mc_draft=TOKEN — reusing the existing, working draft-render flow. Because
// the preview target has refresh:true, Statamic reloads this route with a fresh
// token on every change, so the preview always reflects the latest edits.
Route::get('/mc-live-preview', function (Request $request) {
    $token = $request->statamicToken();
    $entry = $token ? LivePreview::item($token) : null;

    if (! $entry) {
        return response('Live Preview token missing or expired.', 400);
    }

    // Render the (unsaved) Live Preview entry through its own Statamic template
    // + layout, SAME-ORIGIN on this CMS host. The templates render page_blocks
    // via the _blocks partial, so the CP Live Preview shows a faithful, live
    // content preview — no cross-origin iframe to the Next.js site, so Statamic's
    // native hot-reload works and updates appear as you type.
    return $entry->toResponse($request);
});

// ── Live Preview data endpoint (JSON) ────────────────────────────────────────
//
// Same-origin endpoint the bridge calls on every Statamic Live Preview
// `postMessage` (statamic.preview.updated). Statamic provides a fresh token on
// each edit/reorder; this returns the current UNSAVED entry's page_blocks as
// JSON so the bridge can re-POST them to Next.js and refresh the preview iframe
// live — without waiting for a save.
Route::get('/mc-live-preview-data', function (Request $request) {
    $token = $request->statamicToken();
    $entry = $token ? LivePreview::item($token) : null;

    if (! $entry) {
        return response()->json(['error' => 'Live Preview token missing or expired.'], 400);
    }

    $slug = $entry->slug();

    return response()->json([
        'collection'     => optional($entry->collection())->handle() ?? 'pages',
        'slug'           => $slug,
        'title'          => $entry->value('title'),
        'seoDescription' => $entry->value('seo_description'),
        'pageBlocks'     => $entry->value('page_blocks') ?? [],
    ]);
});

// Route::statamic('example', 'example-view', [
//    'title' => 'Example'
// ]);

// ── Content calendar (Statamic CP add-on) ────────────────────────────────────
// Authenticated CP routes — Statamic's 'statamic.cp.authenticated' middleware
// ensures only logged-in CP users can access these.
Route::prefix('cp/calendar')
    ->middleware(['statamic.cp', 'statamic.cp.authenticated'])
    ->group(function () {
        Route::get('/',                          [CalendarController::class, 'index']);
        Route::get('/events',                    [CalendarController::class, 'events']);
        Route::get('/entries/{collection}',      [CalendarController::class, 'listEntries']);
        Route::post('/entry',                    [CalendarController::class, 'createEntry']);
        Route::patch('/entry/{col}/{id}',        [CalendarController::class, 'updateDate']);
        Route::delete('/entry/{col}/{id}/date',  [CalendarController::class, 'clearDate']);
    });

// ── POST /api/collections/{col}/entries ───────────────────────────────────
// Upsert an entry in the given collection.
//
// Loaded here (web.php) instead of api.php so Laravel's own bootstrap
// registers it reliably, regardless of Statamic's service provider behaviour.
// CSRF is exempt for api/* via bootstrap/app.php validateCsrfTokens(except:
// ['api/*']). The full /api/ prefix is required here because web.php routes
// have no automatic prefix, unlike api.php (which Statamic loads under /api).
//
// NOTE: The parameter is named {col} instead of {collection} to avoid
// triggering Statamic's RouteServiceProvider model binding, which intercepts
// any {collection} parameter on routes starting with api/ and attempts to
// resolve it from the Statamic collection store — causing a 404 when the
// collection handle is not yet registered as a content collection.
//
// Body: JSON object; must include either "slug" or "key" (used as slug).
// Creates a new entry or updates an existing one with the same slug.
// Returns the saved entry's data + id + slug.
Route::post('/api/collections/{col}/entries', function (Request $request, string $col) {
    $collection = $col;
    $body = $request->json()->all();

    // Derive slug from body: prefer explicit "slug", fall back to "key", then
    // generate a URL-safe slug from the title if neither is provided.
    $slug = isset($body['slug']) && $body['slug'] !== ''
        ? $body['slug']
        : (isset($body['key']) && $body['key'] !== ''
            ? Str::slug($body['key'], '-')
            : Str::slug($body['title'] ?? ('entry-' . time()), '-'));

    // Check whether an entry with this slug already exists (PHP filter because
    // Stache does not support ->where('slug', ...) reliably on custom fields).
    $all      = Entry::query()->where('collection', $collection)->get();
    $existing = $all->first(fn($e) => $e->slug() === $slug);

    if ($existing) {
        // Merge incoming data over existing data (upsert semantics).
        $merged = array_merge($existing->data()->all(), $body);
        unset($merged['slug'], $merged['id']); // slug is set separately
        $existing->data($merged)->save();
        $entry  = $existing;
        $status = 200;
    } else {
        // Create a new entry.
        $data = $body;
        unset($data['slug'], $data['id']); // slug is set separately
        $entry  = Entry::make()->collection($collection)->slug($slug)->data($data);
        $entry->save();
        $status = 201;
    }

    $raw = $entry->data()->all();
    if (!array_key_exists('is_active', $raw)) {
        $raw['is_active'] = true;
    }

    return response()->json([
        'data' => array_merge($raw, [
            'id'   => $entry->id(),
            'slug' => $entry->slug(),
        ]),
    ], $status);
});

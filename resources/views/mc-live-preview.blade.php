{{--
    Live Preview bridge view (rendered by the /mc-live-preview route).

    Receives the unsaved entry's draft data ($payload), POSTs it to the Next.js
    draft API, and loads the resulting Vercel page (with ?mcdraft=TOKEN) inside
    an iframe — so the Statamic CP Live Preview pane shows the real Next.js
    rendering of the in-progress page blocks.

    Statamic reloads this route with a fresh token on every change
    (preview_targets refresh:true), so each render reflects the latest edits.
--}}
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Live Preview</title>
    <style>
        html, body { margin: 0; padding: 0; height: 100%; overflow: hidden; background: #fff; }
        #mc-preview { display: block; width: 100%; height: 100%; border: 0; }
        #mc-status  { font: 13px/1.5 system-ui, -apple-system, sans-serif; color: #6b7280; padding: 16px; }
    </style>
</head>
<body>
    <script type="application/json" id="mc-draft-data">{!! json_encode($payload, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}</script>
    <div id="mc-status">Live preview laden…</div>
    <iframe id="mc-preview" title="Live preview" style="display:none"></iframe>

    <script>
    (function () {
        var BASE = @json($base);
        var PATH = @json($path);

        var payload = null;
        try { payload = JSON.parse(document.getElementById('mc-draft-data').textContent); } catch (e) {}

        var frame  = document.getElementById('mc-preview');
        var status = document.getElementById('mc-status');

        function show(src) {
            frame.src = src;
            frame.style.display = 'block';
            if (status) status.style.display = 'none';
        }
        function fallback() { show(BASE + PATH); }

        // POST a payload to the Next.js draft store and point the preview iframe
        // at the resulting draft URL. Used for the initial render and for every
        // subsequent live edit.
        function render(payload) {
            return fetch(BASE + '/api/statamic-draft', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(payload)
            })
            .then(function (r) { return r.ok ? r.json() : null; })
            .then(function (resp) {
                if (resp && resp.token) {
                    var sep = PATH.indexOf('?') > -1 ? '&' : '?';
                    show(BASE + PATH + sep + 'mcdraft=' + encodeURIComponent(resp.token));
                } else {
                    fallback();
                }
            })
            .catch(function () { fallback(); });
        }

        // ── Initial render from the baked-in payload ─────────────────────────
        if (!payload) { fallback(); } else { render(payload); }

        // ── Live updates via Statamic Live Preview postMessage ───────────────
        // With the preview target's refresh:false, Statamic posts a message on
        // every change (incl. block reorder) carrying a fresh token. We fetch
        // the current unsaved entry for that token and re-render — no save
        // needed. Debounced so rapid edits collapse into one refresh.
        var debTimer = null;
        function scheduleUpdate(token) {
            if (debTimer) clearTimeout(debTimer);
            debTimer = setTimeout(function () {
                fetch('/mc-live-preview-data?token=' + encodeURIComponent(token), {
                    headers: { 'Accept': 'application/json' }
                })
                .then(function (r) { return r.ok ? r.json() : null; })
                .then(function (p) {
                    if (p && !p.error) render(p);
                })
                .catch(function () {});
            }, 300);
        }

        window.addEventListener('message', function (e) {
            var msg = e.data;
            if (!msg || typeof msg !== 'object') return;
            if (msg.name === 'statamic.preview.updated' && msg.token) {
                scheduleUpdate(msg.token);
            }
        });
    })();
    </script>
</body>
</html>

{{--
    Live Preview bridge view (rendered by the /mc-live-preview route).

    Initial render: POSTs the baked-in unsaved entry to the Next.js draft store
    and loads the resulting Vercel page (?mcdraft=TOKEN) in an iframe.

    Live updates: Statamic Live Preview (preview target refresh:false) posts a
    `statamic.preview.updated` message with a fresh token on every change incl.
    block reorder. We fetch the current unsaved entry for that token via the
    same-origin /mc-live-preview-data endpoint, re-POST it, and refresh the
    iframe — so the preview tracks edits without a save. Debounced to coalesce
    rapid edits.
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

        // POST a payload to the Next.js draft store, point the iframe at the
        // resulting draft URL. A sequence guard ensures only the newest render
        // wins when edits arrive faster than the round-trip completes.
        var renderSeq = 0;
        function render(p) {
            var seq = ++renderSeq;
            return fetch(BASE + '/api/statamic-draft', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(p)
            })
            .then(function (r) { return r.ok ? r.json() : null; })
            .then(function (resp) {
                if (seq !== renderSeq) return;          // a newer edit superseded this one
                if (resp && resp.token) {
                    var sep = PATH.indexOf('?') > -1 ? '&' : '?';
                    show(BASE + PATH + sep + 'mcdraft=' + encodeURIComponent(resp.token));
                } else {
                    fallback();
                }
            })
            .catch(function () { if (seq === renderSeq) fallback(); });
        }

        // ── Initial render from the baked-in payload ─────────────────────────
        if (!payload) { fallback(); } else { render(payload); }

        // ── Live updates via Statamic Live Preview postMessage ───────────────
        var debTimer = null;
        function scheduleUpdate(token) {
            if (debTimer) clearTimeout(debTimer);
            debTimer = setTimeout(function () {
                fetch('/mc-live-preview-data?token=' + encodeURIComponent(token), { headers: { 'Accept': 'application/json' } })
                .then(function (r) { return r.ok ? r.json() : null; })
                .then(function (p) { if (p && !p.error) render(p); })
                .catch(function () {});
            }, 300);
        }

        window.addEventListener('message', function (e) {
            var msg = e.data;
            if (!msg || typeof msg !== 'object') return;
            var isUpdate = msg.name === 'statamic.preview.updated' || msg.type === 'statamic.preview.updated';
            var token = msg.token || (msg.data && msg.data.token);
            if (isUpdate && token) scheduleUpdate(token);
        });
    })();
    </script>
</body>
</html>

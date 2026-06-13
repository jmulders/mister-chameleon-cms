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
        function log() {
            try {
                var a = Array.prototype.slice.call(arguments);
                a.unshift('[mc-bridge]');
                console.log.apply(console, a);
            } catch (e) {}
        }
        log('init — BASE=' + BASE + ' PATH=' + PATH);

        var payload = null;
        try { payload = JSON.parse(document.getElementById('mc-draft-data').textContent); } catch (e) {}
        log('initial payload blocks:', payload && payload.pageBlocks ? payload.pageBlocks.length : '(none)');

        var frame  = document.getElementById('mc-preview');
        var status = document.getElementById('mc-status');

        function setStatus(t) { if (status) status.textContent = t; }
        function show(src) {
            log('show iframe →', src);
            frame.src = src;
            frame.style.display = 'block';
            if (status) status.style.display = 'none';
        }
        function fallback() { log('fallback (no draft)'); show(BASE + PATH); }

        // POST a payload to the Next.js draft store and point the preview iframe
        // at the resulting draft URL. Used for the initial render and every edit.
        var renderSeq = 0;
        function render(p) {
            var seq = ++renderSeq;
            var n = p && p.pageBlocks ? p.pageBlocks.length : '?';
            log('render #' + seq + ' — POST draft (' + n + ' blocks)');
            setStatus('Voorbeeld bijwerken…');
            return fetch(BASE + '/api/statamic-draft', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(p)
            })
            .then(function (r) { log('render #' + seq + ' draft status', r.status); return r.ok ? r.json() : null; })
            .then(function (resp) {
                if (seq !== renderSeq) { log('render #' + seq + ' stale, skip'); return; }
                if (resp && resp.token) {
                    var sep = PATH.indexOf('?') > -1 ? '&' : '?';
                    show(BASE + PATH + sep + 'mcdraft=' + encodeURIComponent(resp.token));
                } else { fallback(); }
            })
            .catch(function (err) { log('render #' + seq + ' ERROR', err && err.message); fallback(); });
        }

        // ── Initial render ────────────────────────────────────────────────────
        if (!payload) { fallback(); } else { render(payload); }

        // ── Live updates via Statamic Live Preview postMessage ────────────────
        var debTimer = null;
        function scheduleUpdate(token) {
            log('scheduleUpdate token=' + String(token).slice(0, 12));
            if (debTimer) clearTimeout(debTimer);
            debTimer = setTimeout(function () {
                fetch('/mc-live-preview-data?token=' + encodeURIComponent(token), { headers: { 'Accept': 'application/json' } })
                .then(function (r) { log('data status', r.status); return r.ok ? r.json() : null; })
                .then(function (p) {
                    if (p && !p.error) { render(p); }
                    else { log('data endpoint returned error/empty', p); }
                })
                .catch(function (err) { log('data fetch ERROR', err && err.message); });
            }, 250);
        }

        // Extract a live-preview token from whatever message shape Statamic sends.
        function tokenFromMessage(msg) {
            if (!msg || typeof msg !== 'object') return null;
            if (msg.token) return msg.token;
            if (msg.data && msg.data.token) return msg.data.token;
            return null;
        }

        window.addEventListener('message', function (e) {
            var msg = e.data;
            if (!msg || typeof msg !== 'object') return;
            // Log every structured message so we can see Statamic's real format.
            log('postMessage', JSON.stringify({ name: msg.name, type: msg.type, hasToken: !!tokenFromMessage(msg), keys: Object.keys(msg) }));
            var isUpdate =
                msg.name === 'statamic.preview.updated' ||
                msg.type === 'statamic.preview.updated' ||
                msg.name === 'statamic:live-preview' ||
                msg.type === 'statamic:live-preview';
            var token = tokenFromMessage(msg);
            if (isUpdate && token) { scheduleUpdate(token); }
        });
    })();
    </script>
</body>
</html>

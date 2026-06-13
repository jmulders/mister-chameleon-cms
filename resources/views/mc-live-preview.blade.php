{{--
    Live Preview bridge view (rendered by the /mc-live-preview route).

    Renders the unsaved entry by POSTing its blocks to the Next.js draft store
    and loading the lightweight /mc-preview route (?mcdraft=TOKEN) in an iframe.

    Live updates: changes (incl. block reorder) are detected via Statamic's
    postMessage AND by polling the parent CP's reactive publish-form values,
    deduped by a content fingerprint. Each change re-POSTs the current blocks.

    Double-buffered iframes: the new preview loads in a hidden iframe and is
    swapped in only once fully loaded, so the visible preview never goes blank
    or flickers while the next render is in flight.
--}}
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Live Preview</title>
    <style>
        html, body { margin: 0; padding: 0; height: 100%; overflow: hidden; background: #fff; }
        .mc-frame { position: absolute; inset: 0; width: 100%; height: 100%; border: 0; }
        #mc-status { position: absolute; top: 0; left: 0; font: 13px/1.5 system-ui, -apple-system, sans-serif; color: #6b7280; padding: 16px; z-index: 3; }
    </style>
</head>
<body>
    <script type="application/json" id="mc-draft-data">{!! json_encode($payload, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}</script>
    <div id="mc-status">Live preview laden…</div>
    <iframe id="mc-a" class="mc-frame" title="Live preview"></iframe>
    <iframe id="mc-b" class="mc-frame" title="Live preview" style="visibility:hidden"></iframe>

    <script>
    (function () {
        var BASE = @json($base);
        var PATH = @json($path);
        var DEBUG = true;
        function log() { if (!DEBUG) return; try { var a = [].slice.call(arguments); a.unshift('[mc-bridge]'); console.log.apply(console, a); } catch (e) {} }

        var payload = null;
        try { payload = JSON.parse(document.getElementById('mc-draft-data').textContent); } catch (e) {}

        var status = document.getElementById('mc-status');
        var frames = [document.getElementById('mc-a'), document.getElementById('mc-b')];
        var front  = 0;
        frames[0].style.visibility = 'visible';
        frames[1].style.visibility = 'hidden';

        // ── Double-buffered show ──────────────────────────────────────────────
        // Load the new URL into the hidden (back) iframe; swap it to the front
        // only after it finishes loading. The currently visible iframe stays put
        // until then, so there is never a blank/flicker. Rapid calls keep
        // overwriting the back buffer; only the final load swaps in.
        var showSeq = 0;
        function show(src) {
            var mySeq = ++showSeq;
            var back  = frames[1 - front];
            back.onload = function () {
                back.onload = null;
                if (mySeq !== showSeq) return;          // a newer render is loading
                back.style.visibility = 'visible';
                frames[front].style.visibility = 'hidden';
                front = 1 - front;
                if (status) status.style.display = 'none';
                log('swapped in #' + mySeq);
            };
            back.src = src;
        }
        function fallback() { show(BASE + PATH); }

        function fp(blocks, title) {
            try { return JSON.stringify(blocks || []) + '|' + (title || ''); } catch (e) { return String(Math.random()); }
        }
        var lastFp = payload ? fp(payload.pageBlocks, payload.title) : '';

        function render(p) {
            log('render (' + ((p.pageBlocks || []).length) + ' blocks)');
            return fetch(BASE + '/api/statamic-draft', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(p)
            })
            .then(function (r) { log('POST', r.status); return r.ok ? r.json() : null; })
            .then(function (resp) {
                if (resp && resp.token) {
                    show(BASE + '/mc-preview?mcdraft=' + encodeURIComponent(resp.token));
                } else { fallback(); }
            })
            .catch(function (e) { log('render error', e && e.message); });
        }

        var debTimer = null;
        function maybeRender(blocks, title, seo) {
            if (!Array.isArray(blocks)) return;
            var f = fp(blocks, title);
            if (f === lastFp) return;
            lastFp = f;
            log('change detected');
            if (debTimer) clearTimeout(debTimer);
            debTimer = setTimeout(function () {
                render({
                    collection:     payload ? payload.collection : 'pages',
                    slug:           payload ? payload.slug : 'home',
                    title:          title !== undefined ? title : (payload ? payload.title : ''),
                    seoDescription: seo   !== undefined ? seo   : (payload ? payload.seoDescription : null),
                    pageBlocks:     blocks
                });
            }, 450);
        }

        // ── Initial render ────────────────────────────────────────────────────
        if (!payload) { fallback(); } else { render(payload); }

        // ── Mechanism 1: Statamic postMessage ────────────────────────────────
        window.addEventListener('message', function (e) {
            var msg = e.data;
            if (!msg || typeof msg !== 'object') return;
            var isUpdate = msg.name === 'statamic.preview.updated' || msg.type === 'statamic.preview.updated';
            var token = msg.token || (msg.data && msg.data.token);
            if (!isUpdate || !token) return;
            fetch('/mc-live-preview-data?token=' + encodeURIComponent(token), { headers: { 'Accept': 'application/json' } })
            .then(function (r) { return r.ok ? r.json() : null; })
            .then(function (p) { if (p && !p.error) maybeRender(p.pageBlocks, p.title, p.seoDescription); })
            .catch(function () {});
        });

        // ── Mechanism 2: poll the parent CP's reactive publish-form values ────
        function scanProvides(prov) {
            if (!prov || typeof prov !== 'object') return null;
            try {
                for (var key in prov) {
                    try {
                        var val = prov[key];
                        if (!val || typeof val !== 'object') continue;
                        if (Array.isArray(val.page_blocks)) return val;
                        if (val.values && Array.isArray(val.values.page_blocks)) return val.values;
                        if (val.__v_isRef && val.value) {
                            if (Array.isArray(val.value.page_blocks)) return val.value;
                            if (val.value.values && Array.isArray(val.value.values.page_blocks)) return val.value.values;
                        }
                        if (val.values && val.values.__v_isRef) {
                            var vv = val.values.value;
                            if (vv && Array.isArray(vv.page_blocks)) return vv;
                        }
                    } catch (ex) {}
                }
            } catch (e) {}
            return null;
        }
        function searchInstance(inst, depth) {
            if (!inst || depth > 30) return null;
            try {
                var f = scanProvides(inst.provides);
                if (f) return f;
                var ss = inst.setupState;
                if (ss && typeof ss === 'object') {
                    if (Array.isArray(ss.page_blocks)) return ss;
                    if (ss.values && Array.isArray(ss.values.page_blocks)) return ss.values;
                }
                if (inst.subTree) return walkVNode(inst.subTree, depth + 1);
            } catch (e) {}
            return null;
        }
        function walkVNode(vnode, depth) {
            if (!vnode || depth > 30) return null;
            try {
                if (vnode.component) { var r = searchInstance(vnode.component, depth); if (r) return r; }
                var ch = vnode.children;
                if (Array.isArray(ch)) {
                    for (var i = 0; i < ch.length && i < 40; i++) {
                        if (ch[i] && typeof ch[i] === 'object') { var r2 = walkVNode(ch[i], depth + 1); if (r2) return r2; }
                    }
                }
            } catch (e) {}
            return null;
        }
        function findViaDom(doc) {
            try {
                var sels = ['[data-fieldtype="replicator"]', '[class*="replicator"]', '.publish-fields', '.publish-form', 'form'];
                for (var s = 0; s < sels.length; s++) {
                    var els = doc.querySelectorAll(sels[s]);
                    for (var ei = 0; ei < els.length && ei < 12; ei++) {
                        var cur = els[ei].__vueParentComponent;
                        for (var d = 0; d < 30 && cur; d++) {
                            var f = scanProvides(cur.provides);
                            if (f) return f;
                            var ss = cur.setupState;
                            if (ss && typeof ss === 'object') {
                                if (Array.isArray(ss.page_blocks)) return ss;
                                if (ss.values && Array.isArray(ss.values.page_blocks)) return ss.values;
                            }
                            cur = cur.parent;
                        }
                    }
                }
            } catch (e) {}
            return null;
        }
        var _cached = null, _warned = false;
        function findValues() {
            if (_cached && Array.isArray(_cached.page_blocks)) return _cached;
            _cached = null;
            try {
                var p = window.parent;
                if (!p || !p.Statamic || !p.Statamic.$app) return null;
                var app = p.Statamic.$app;
                var root = app._instance;
                if (!root && app._container && app._container._vnode && app._container._vnode.component) root = app._container._vnode.component;
                if (!root) { var el = p.document.querySelector('[data-v-app]'); if (el && el._vnode && el._vnode.component) root = el._vnode.component; }
                if (root) _cached = searchInstance(root, 0);
                if (!_cached) _cached = findViaDom(p.document);
                if (_cached) { log('reactive values found (' + _cached.page_blocks.length + ' blocks)'); _warned = false; }
                else if (!_warned) { log('reactive values not found yet'); _warned = true; }
            } catch (e) {}
            return _cached;
        }
        function poll() { var v = findValues(); if (v) maybeRender(v.page_blocks, v.title, v.seo_description); }

        setInterval(poll, 600);
        try {
            var pdoc = window.parent.document;
            if (pdoc && pdoc.body) {
                new MutationObserver(poll).observe(pdoc.body, { childList: true, subtree: true, characterData: true });
                log('MutationObserver wired');
            }
        } catch (e) {}
    })();
    </script>
</body>
</html>

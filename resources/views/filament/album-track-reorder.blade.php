<div id="alb-track-panel" style="margin-top:2rem;border-radius:12px;overflow:hidden;border:1px solid var(--alb-border);background:var(--alb-bg);">
<style>
#alb-track-panel {
    --alb-bg: #ffffff;
    --alb-bg2: #f9fafb;
    --alb-border: #e5e7eb;
    --alb-border2: #f3f4f6;
    --alb-text: #111827;
    --alb-muted: #6b7280;
    --alb-subtle: #9ca3af;
    --alb-accent: #7c3aed;
    --alb-green-bg: #d1fae5;
    --alb-green-txt: #065f46;
    --alb-drag: #d1d5db;
    --alb-input-bg: #ffffff;
    --alb-input-border: #d1d5db;
    --alb-hover: #f5f3ff;
    --alb-shadow: 0 1px 3px rgba(0,0,0,.08);
}
.dark #alb-track-panel,
[data-theme="dark"] #alb-track-panel {
    --alb-bg: #1e1e2e;
    --alb-bg2: #27273a;
    --alb-border: #3f3f5a;
    --alb-border2: #2d2d42;
    --alb-text: #e2e2f0;
    --alb-muted: #a0a0c0;
    --alb-subtle: #6b6b90;
    --alb-accent: #a78bfa;
    --alb-green-bg: #064e3b;
    --alb-green-txt: #6ee7b7;
    --alb-drag: #4b4b6a;
    --alb-input-bg: #27273a;
    --alb-input-border: #4b4b6a;
    --alb-hover: #2d2d42;
    --alb-shadow: 0 1px 3px rgba(0,0,0,.3);
}
#alb-track-panel .alb-header {
    display:flex;align-items:center;justify-content:space-between;
    padding:14px 16px;border-bottom:1px solid var(--alb-border);
}
#alb-track-panel .alb-title {
    font-weight:600;font-size:14px;color:var(--alb-text);margin:0;
}
#alb-track-panel .alb-status-msg {
    font-size:12px;color:#10b981;display:none;
}
#alb-track-panel .alb-body { padding:12px 16px; }
#alb-track-panel .alb-hint {
    font-size:12px;color:var(--alb-subtle);margin-bottom:10px;
}
#alb-track-panel .alb-row {
    display:flex;align-items:center;gap:10px;
    padding:9px 0;border-bottom:1px solid var(--alb-border2);
    cursor:grab;user-select:none;transition:background .15s;
}
#alb-track-panel .alb-row:last-child { border-bottom:none; }
#alb-track-panel .alb-row:active { cursor:grabbing; }
#alb-track-panel .alb-row.alb-dragging { opacity:.4; }
#alb-track-panel .alb-drag-icon { color:var(--alb-drag);flex-shrink:0; }
#alb-track-panel .alb-num {
    font-size:12px;color:var(--alb-subtle);width:20px;text-align:center;flex-shrink:0;
}
#alb-track-panel .alb-name {
    flex:1;font-size:13px;color:var(--alb-text);
    white-space:nowrap;overflow:hidden;text-overflow:ellipsis;
}
#alb-track-panel .alb-date {
    font-size:11px;color:var(--alb-subtle);margin-right:6px;
}
#alb-track-panel .alb-badge {
    font-size:11px;padding:2px 8px;border-radius:999px;flex-shrink:0;
    background:var(--alb-bg2);color:var(--alb-muted);
}
#alb-track-panel .alb-badge.pub {
    background:var(--alb-green-bg);color:var(--alb-green-txt);
}
#alb-track-panel .alb-edit-btn {
    font-size:12px;color:var(--alb-accent);text-decoration:none;flex-shrink:0;
}
#alb-track-panel .alb-edit-btn:hover { text-decoration:underline; }
#alb-track-panel .alb-remove-btn {
    background:none;border:none;cursor:pointer;color:var(--alb-subtle);
    flex-shrink:0;padding:0 2px;line-height:1;font-size:16px;
}
#alb-track-panel .alb-remove-btn:hover { color:#ef4444; }

/* Search section */
#alb-track-panel .alb-search-section {
    margin-top:14px;padding-top:14px;border-top:1px solid var(--alb-border);
}
#alb-track-panel .alb-search-label {
    font-size:13px;font-weight:600;color:var(--alb-text);margin-bottom:8px;
}
#alb-track-panel .alb-search-wrap {
    display:flex;gap:8px;align-items:center;
}
#alb-track-panel .alb-search-input {
    flex:1;padding:7px 10px;border-radius:8px;
    border:1px solid var(--alb-input-border);
    background:var(--alb-input-bg);color:var(--alb-text);
    font-size:13px;outline:none;
}
#alb-track-panel .alb-search-input:focus {
    border-color:var(--alb-accent);box-shadow:0 0 0 2px rgba(124,58,237,.15);
}
#alb-track-panel .alb-search-results {
    margin-top:6px;max-height:200px;overflow-y:auto;
    border:1px solid var(--alb-border);border-radius:8px;
    background:var(--alb-bg);display:none;
}
#alb-track-panel .alb-result-item {
    display:flex;align-items:center;justify-content:space-between;
    padding:8px 12px;cursor:pointer;border-bottom:1px solid var(--alb-border2);
    font-size:13px;color:var(--alb-text);
}
#alb-track-panel .alb-result-item:last-child { border-bottom:none; }
#alb-track-panel .alb-result-item:hover { background:var(--alb-hover); }
#alb-track-panel .alb-add-btn {
    font-size:12px;color:var(--alb-accent);border:1px solid var(--alb-accent);
    background:none;border-radius:6px;padding:3px 9px;cursor:pointer;
}
#alb-track-panel .alb-add-btn:hover { background:var(--alb-hover); }
#alb-track-panel .alb-empty-search {
    padding:12px;text-align:center;font-size:13px;color:var(--alb-subtle);
}
</style>

<div class="alb-header">
    <p class="alb-title">آهنگ‌های این آلبوم ({{ count($rows) }})</p>
    <span id="admin-reorder-status" class="alb-status-msg">✓ ذخیره شد</span>
</div>

<div class="alb-body">
    <p class="alb-hint">برای تغییر ترتیب، ردیف‌ها را بکشید و رها کنید.</p>

    <div id="admin-tracks-sortable">
        @foreach($rows as $row)
        <div class="alb-row" data-id="{{ $row['id'] }}">
            <span class="alb-drag-icon">
                <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8h16M4 16h16"/>
                </svg>
            </span>
            <span class="admin-track-num alb-num">{{ $row['track_number'] }}</span>
            <span class="alb-name">
                {!! $row['title'] !!}
                @if($row['jalali'])
                    <span class="alb-date">{{ $row['jalali'] }}</span>
                @endif
            </span>
            <span class="alb-badge {{ $row['status']==='published' ? 'pub' : '' }}">
                {{ $row['status'] === 'published' ? 'منتشر' : 'پیش‌نویس' }}
            </span>
            <a href="{{ $row['edit_url'] }}" class="alb-edit-btn">ویرایش</a>
            <button class="alb-remove-btn" data-track-id="{{ $row['id'] }}" title="جدا کردن از آلبوم">×</button>
        </div>
        @endforeach
    </div>

    {{-- Add new track --}}
    <div style="margin-top:14px;padding-top:14px;border-top:1px solid var(--alb-border);">
        <a href="{{ route('filament.admin.resources.tracks.create') }}?album_id={{ $album->id }}"
           style="display:inline-flex;align-items:center;gap:6px;padding:7px 14px;border-radius:8px;background:var(--alb-accent);color:#fff;font-size:13px;text-decoration:none;font-weight:500;">
            <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            آهنگ جدید
        </a>
    </div>
</div>
</div>

<script>
(function(){
    var panel      = document.getElementById('alb-track-panel');
    var list       = document.getElementById('admin-tracks-sortable');
    var statusEl   = document.getElementById('admin-reorder-status');
    if (!list) return;

    var reorderUrl = '{{ $reorderUrl }}';
    var detachUrl  = '{{ route("filament.admin.album-track-detach", $album) }}';
    var csrf       = '{{ $csrfToken }}';
    var dragged    = null;

    /* ---- Dark mode detection ---- */
    function isDark() {
        return document.documentElement.classList.contains('dark')
            || document.documentElement.getAttribute('data-theme') === 'dark'
            || (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches
                && !document.documentElement.classList.contains('light'));
    }
    function applyTheme() {
        if (isDark()) panel.setAttribute('data-theme','dark');
        else panel.removeAttribute('data-theme');
    }
    applyTheme();
    var obs = new MutationObserver(applyTheme);
    obs.observe(document.documentElement, {attributes:true, attributeFilter:['class','data-theme']});

    /* ---- Drag & drop ---- */
    function makeDraggable(item) {
        item.draggable = true;
        item.addEventListener('dragstart', function(e) {
            dragged = item;
            item.classList.add('alb-dragging');
            e.dataTransfer.effectAllowed = 'move';
        });
        item.addEventListener('dragend', function() {
            item.classList.remove('alb-dragging');
            dragged = null;
            saveOrder();
        });
        item.addEventListener('dragover', function(e) {
            e.preventDefault();
            if (!dragged || dragged === item) return;
            var mid = item.getBoundingClientRect().top + item.offsetHeight / 2;
            if (e.clientY < mid) list.insertBefore(dragged, item);
            else list.insertBefore(dragged, item.nextSibling);
        });
    }
    list.querySelectorAll('.alb-row').forEach(makeDraggable);

    /* ---- Remove buttons ---- */
    function bindRemove(btn) {
        btn.addEventListener('click', function() {
            var trackId = parseInt(btn.dataset.trackId);
            var row = btn.closest('.alb-row');
            fetch(detachUrl, {
                method:'POST',
                headers:{'Content-Type':'application/json','X-CSRF-TOKEN':csrf},
                body:JSON.stringify({track_id: trackId})
            }).then(function(r){return r.json();}).then(function(d){
                if (d.ok) {
                    row.remove();
                    updateCount();
                    showStatus('× جدا شد');
                }
            });
        });
    }
    list.querySelectorAll('.alb-remove-btn').forEach(bindRemove);

    /* ---- Save order ---- */
    function saveOrder() {
        var order = [];
        list.querySelectorAll('.alb-row').forEach(function(el, i) {
            order.push(parseInt(el.dataset.id));
            var n = el.querySelector('.admin-track-num');
            if (n) n.textContent = i + 1;
        });
        fetch(reorderUrl, {
            method:'POST',
            headers:{'Content-Type':'application/json','X-CSRF-TOKEN':csrf},
            body:JSON.stringify({order:order})
        }).then(function(r){return r.json();}).then(function(d){
            if (d.ok) showStatus('✓ ذخیره شد');
        });
    }

    /* ---- Status flash ---- */
    function showStatus(msg) {
        statusEl.textContent = msg;
        statusEl.style.display = 'inline';
        clearTimeout(statusEl._t);
        statusEl._t = setTimeout(function(){ statusEl.style.display = 'none'; }, 2500);
    }

    /* ---- Track count in header ---- */
    function updateCount() {
        var title = panel.querySelector('.alb-title');
        if (title) {
            var n = list.querySelectorAll('.alb-row').length;
            title.textContent = 'آهنگ‌های این آلبوم (' + n + ')';
        }
    }

})();
</script>

{{--
  Jalali date input — pure vanilla JS, no Alpine dependency.
  Props: name, value (Gregorian Y-m-d or null), label, required
--}}
@props(['name', 'value' => null, 'label' => 'تاریخ', 'required' => false])

@php
    $display = $value ? \App\Helpers\Jalali::format($value, 'Y/m/d') : '';
    $displayValue = old($name, $display);
    $uid = 'jdp' . substr(md5($name . uniqid()), 0, 10);
@endphp

<div class="jdp-wrap" id="wrap{{ $uid }}">
    <label class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-1.5">
        {{ $label }}{{ $required ? ' *' : '' }}
    </label>
    <div class="relative">
        <input type="text"
               name="{{ $name }}"
               id="inp{{ $uid }}"
               value="{{ $displayValue }}"
               onclick="jdpOpen('{{ $uid }}')"
               placeholder="مثال: ۱۴۰۳/۰۲/۱۵"
               autocomplete="off"
               class="w-full rounded-xl border border-surface-300 dark:border-surface-600 bg-white dark:bg-surface-800 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 cursor-pointer pl-10"
               {{ $required ? 'required' : '' }}
               readonly>
        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-surface-400 pointer-events-none">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
        </span>
    </div>
</div>

{{-- Popup portal - appended to body by JS --}}
<div id="pop{{ $uid }}"
     onclick="event.stopPropagation()"
     style="display:none;position:fixed;z-index:99999;width:304px;border-radius:14px;background:#ffffff;border:1px solid #e5e7eb;box-shadow:0 20px 60px rgba(0,0,0,.18);padding:14px;font-family:inherit;direction:rtl;"></div>

<script>
(function(){
    /* ── Jalali math (once) ─────────────────────────────────── */
    if(!window._JM){
        window._JM=1;
        window.jGJ=function(gy,gm,gd){var gDM=[0,31,59,90,120,151,181,212,243,273,304,334],jy;if(gy>1600){jy=979;gy-=1600;}else{jy=0;gy-=621;}var gy2=(gm>2)?(gy+1):gy;var d=(365*gy)+Math.floor((gy2+3)/4)-Math.floor((gy2+99)/100)+Math.floor((gy2+399)/400)-80+gd+gDM[gm-1];jy+=33*Math.floor(d/12053);d=d%12053;jy+=4*Math.floor(d/1461);d=d%1461;if(d>365){jy+=Math.floor((d-1)/365);d=(d-1)%365;}var jm=(d<186)?1+Math.floor(d/31):7+Math.floor((d-186)/30);return[jy,jm,1+((d<186)?(d%31):((d-186)%30))];};
        window.jJG=function(jy,jm,jd){var gy;if(jy>979){gy=1600;jy-=979;}else{gy=621;}var d=(365*jy)+Math.floor(jy/33)*8+Math.floor((jy%33+3)/4)+78+jd+((jm<7)?(jm-1)*31:((jm-7)*30)+186);gy+=400*Math.floor(d/146097);d=d%146097;if(d>36524){d--;gy+=100*Math.floor(d/36524);d=d%36524;if(d>=365)d++;}gy+=4*Math.floor(d/1461);d=d%1461;if(d>365){gy+=Math.floor((d-1)/365);d=(d-1)%365;}var gd2=d+1,sa=[0,31,(gy%4===0&&(gy%100!==0||gy%400===0))?29:28,31,30,31,30,31,31,30,31,30,31],gm2=0;for(;gd2>sa[gm2+1];gm2++)gd2-=sa[gm2+1];return[gy,gm2+1,gd2];};
        window.jDIM=function(jy,jm){return jm<=6?31:jm<=11?30:((jy-979)%33%4===0?30:29);};
        window.jDOW=function(jy,jm){var g=window.jJG(jy,jm,1);return(new Date(g[0],g[1]-1,g[2]).getDay()+1)%7;};
        window.jNow=function(){var n=new Date();return window.jGJ(n.getFullYear(),n.getMonth()+1,n.getDate());};
    }

    /* ── State ─────────────────────────────────────────────── */
    var uid='{{ $uid }}';
    var MN=['فروردین','اردیبهشت','خرداد','تیر','مرداد','شهریور','مهر','آبان','آذر','دی','بهمن','اسفند'];
    var DN=['ش','ی','د','س','چ','پ','ج'];

    var initVal='{{ addslashes($displayValue) }}';
    var parts=initVal.split('/');
    var S={year:0,month:0,day:0,inpEl:null,popEl:null};
    if(parts.length===3&&+parts[0]>1300){S.year=+parts[0];S.month=+parts[1];S.day=+parts[2];}
    else{var tn=jNow();S.year=tn[0];S.month=tn[1];}
    window['_S'+uid]=S;

    /* ── DOM refs (lazy) ──────────────────────────────────── */
    function ensureRefs(){
        if(!S.inpEl){
            S.inpEl=document.getElementById('inp'+uid);
            S.popEl=document.getElementById('pop'+uid);
            if(S.popEl&&S.popEl.parentNode!==document.body)
                document.body.appendChild(S.popEl);
        }
    }

    /* ── Build popup HTML ─────────────────────────────────── */
    function buildHTML(){
        var t=jNow(),fd=jDOW(S.year,S.month),dim=jDIM(S.year,S.month),cells=[];
        for(var i=0;i<fd;i++)cells.push(0);
        for(var d=1;d<=dim;d++)cells.push(d);
        while(cells.length%7!==0)cells.push(0);

        var yO='';for(var y=1380;y<=1420;y++)yO+='<option value="'+y+'"'+(y===S.year?' selected':'')+'>'+y+'</option>';
        var mO='';MN.forEach(function(m,i){mO+='<option value="'+(i+1)+'"'+(i+1===S.month?' selected':'')+'>'+m+'</option>';});

        var BST='padding:5px 7px;border-radius:8px;border:1px solid #e5e7eb;background:#f9fafb;cursor:pointer;display:flex;align-items:center;flex-shrink:0;';
        var SST='border:1px solid #d1d5db;border-radius:8px;padding:4px 6px;font-size:12px;font-weight:600;background:#fff;color:#111827;outline:none;cursor:pointer;';

        var h='<div style="display:flex;align-items:center;gap:4px;margin-bottom:10px;">';
        h+='<button type="button" onmousedown="jdpNav(\''+uid+'\',1);event.preventDefault();" style="'+BST+'"><svg width="13" height="13" fill="none" stroke="#6b7280" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg></button>';
        h+='<select onmousedown="event.stopPropagation()" onchange="jdpSetM(\''+uid+'\',this.value)" style="flex:1;'+SST+'">'+mO+'</select>';
        h+='<select onmousedown="event.stopPropagation()" onchange="jdpSetY(\''+uid+'\',this.value)" style="width:68px;'+SST+'">'+yO+'</select>';
        h+='<button type="button" onmousedown="jdpNav(\''+uid+'\',-1);event.preventDefault();" style="'+BST+'"><svg width="13" height="13" fill="none" stroke="#6b7280" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/></svg></button>';
        h+='</div>';

        h+='<div style="display:grid;grid-template-columns:repeat(7,1fr);margin-bottom:4px;">';
        DN.forEach(function(d){h+='<div style="text-align:center;font-size:11px;color:#9ca3af;padding:2px 0;">'+d+'</div>';});
        h+='</div>';

        for(var r=0;r<cells.length/7;r++){
            h+='<div style="display:grid;grid-template-columns:repeat(7,1fr);margin-bottom:2px;">';
            for(var c=0;c<7;c++){
                var cell=cells[r*7+c];
                var isT=cell&&cell===t[2]&&S.month===t[1]&&S.year===t[0];
                var isS=cell&&cell===S.day;
                var cs='width:28px;height:28px;margin:auto;display:flex;align-items:center;justify-content:center;font-size:12px;border-radius:50%;border:none;cursor:pointer;';
                if(!cell) cs+='opacity:0;pointer-events:none;background:transparent;';
                else if(isS) cs+='background:#7c3aed;color:#fff;font-weight:700;';
                else if(isT) cs+='background:#ede9fe;color:#6d28d9;font-weight:600;';
                else cs+='background:transparent;color:#374151;';
                h+='<button type="button" style="'+cs+'"'+(cell?' onmousedown="jdpPick(\''+uid+'\','+cell+');event.preventDefault();"':' disabled')+'>'+(cell||'')+'</button>';
            }
            h+='</div>';
        }

        h+='<div style="display:flex;justify-content:space-between;margin-top:8px;padding-top:8px;border-top:1px solid #f3f4f6;">';
        h+='<button type="button" onmousedown="jdpToday(\''+uid+'\');event.preventDefault();" style="font-size:12px;color:#7c3aed;background:none;border:none;cursor:pointer;padding:0;">امروز</button>';
        h+='<button type="button" onmousedown="jdpClear(\''+uid+'\');event.preventDefault();" style="font-size:12px;color:#f87171;background:none;border:none;cursor:pointer;padding:0;">پاک کردن</button>';
        h+='</div>';
        return h;
    }

    /* ── Position popup ──────────────────────────────────── */
    function position(){
        var r=S.inpEl.getBoundingClientRect(),pw=304;
        var top=r.bottom+6,left=r.right-pw;
        if(left<8)left=8;
        if(left+pw>window.innerWidth-8)left=window.innerWidth-pw-8;
        if(window.innerHeight-r.bottom<380)top=Math.max(8,r.top-6-380);
        S.popEl.style.top=top+'px';
        S.popEl.style.left=left+'px';
    }

    /* ── Public API (namespaced, not overwritten by multiple instances) ── */
    window['jdpOpen']=window['jdpOpen']||function(id){
        var s=window['_S'+id];if(!s)return;
        // ensure refs for this instance
        if(!s.inpEl){s.inpEl=document.getElementById('inp'+id);s.popEl=document.getElementById('pop'+id);if(s.popEl&&s.popEl.parentNode!==document.body)document.body.appendChild(s.popEl);}
        if(s.popEl.style.display!=='none'){s.popEl.style.display='none';return;}
        // delegate build/position to per-instance fn
        window['_render'+id]();
        s.popEl.style.display='block';
    };
    window['jdpNav']=window['jdpNav']||function(id,d){var s=window['_S'+id];if(!s)return;s.month+=d;if(s.month>12){s.month=1;s.year++;}if(s.month<1){s.month=12;s.year--;}window['_render'+id]();};
    window['jdpSetM']=window['jdpSetM']||function(id,v){var s=window['_S'+id];if(!s)return;s.month=+v;window['_render'+id]();};
    window['jdpSetY']=window['jdpSetY']||function(id,v){var s=window['_S'+id];if(!s)return;s.year=+v;window['_render'+id]();};
    window['jdpPick']=window['jdpPick']||function(id,d){
        var s=window['_S'+id];if(!s)return;s.day=d;
        s.inpEl.value=s.year+'/'+String(s.month).padStart(2,'0')+'/'+String(d).padStart(2,'0');
        s.popEl.style.display='none';
    };
    window['jdpToday']=window['jdpToday']||function(id){var t=jNow(),s=window['_S'+id];if(!s)return;s.year=t[0];s.month=t[1];jdpPick(id,t[2]);};
    window['jdpClear']=window['jdpClear']||function(id){var s=window['_S'+id];if(!s)return;s.inpEl.value='';s.day=0;s.popEl.style.display='none';};

    /* ── Per-instance render (captures uid via closure) ──── */
    window['_render'+uid]=function(){
        ensureRefs();
        S.popEl.innerHTML=buildHTML();
        position();
    };

    /* ── Outside click close ─────────────────────────────── */
    document.addEventListener('click',function(e){
        if(!S.popEl||S.popEl.style.display==='none')return;
        var wrap=document.getElementById('wrap'+uid);
        if(wrap&&wrap.contains(e.target))return;
        if(S.popEl.contains(e.target))return;
        S.popEl.style.display='none';
    },true);

    /* ── Init refs on DOM ready ──────────────────────────── */
    if(document.readyState==='loading')
        document.addEventListener('DOMContentLoaded',ensureRefs);
    else
        ensureRefs();
})();
</script>

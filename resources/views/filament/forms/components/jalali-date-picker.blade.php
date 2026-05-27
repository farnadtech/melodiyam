@php
    $uid = 'fjdp' . substr(md5($getStatePath()), 0, 10);
    $val = $getState() ?? '';
@endphp

<x-dynamic-component :component="$getFieldWrapperView()" :field="$field">

{{-- Input wrapper --}}
<div id="wrap{{ $uid }}" style="position:relative;">
    <div style="display:flex;align-items:center;border:1px solid #d1d5db;border-radius:8px;overflow:hidden;background:#fff;box-shadow:0 1px 2px rgba(0,0,0,.05);">
        <input type="text"
               id="inp{{ $uid }}"
               value="{{ $val }}"
               onclick="fjdpToggle('{{ $uid }}')"
               readonly
               autocomplete="off"
               placeholder="مثال: ۱۴۰۴/۰۱/۰۱"
               style="flex:1;border:none;outline:none;padding:8px 12px;font-size:14px;background:transparent;cursor:pointer;color:#111827;min-width:0;" />
        <span style="padding:0 10px;color:#9ca3af;display:flex;align-items:center;pointer-events:none;">
            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
        </span>
    </div>
    {{-- Hidden input Livewire reads --}}
    <input type="hidden" id="hid{{ $uid }}" wire:model.live="{{ $getStatePath() }}" value="{{ $val }}" />
</div>

{{-- Floating popup --}}
<div id="pop{{ $uid }}"
     onclick="event.stopPropagation()"
     style="display:none;position:fixed;z-index:99999;width:19rem;border-radius:12px;background:#ffffff;border:1px solid #e5e7eb;box-shadow:0 20px 60px rgba(0,0,0,.18);padding:14px;font-family:inherit;direction:rtl;">
</div>

</x-dynamic-component>

<script>
(function(){
    if(!window._jMath){
        window._jMath=1;
        window._gToJ=function(gy,gm,gd){var gDM=[0,31,59,90,120,151,181,212,243,273,304,334],jy;if(gy>1600){jy=979;gy-=1600;}else{jy=0;gy-=621;}var gy2=(gm>2)?(gy+1):gy;var d=(365*gy)+Math.floor((gy2+3)/4)-Math.floor((gy2+99)/100)+Math.floor((gy2+399)/400)-80+gd+gDM[gm-1];jy+=33*Math.floor(d/12053);d=d%12053;jy+=4*Math.floor(d/1461);d=d%1461;if(d>365){jy+=Math.floor((d-1)/365);d=(d-1)%365;}var jm=(d<186)?1+Math.floor(d/31):7+Math.floor((d-186)/30);return[jy,jm,1+((d<186)?(d%31):((d-186)%30))];};
        window._jToG=function(jy,jm,jd){var gy;if(jy>979){gy=1600;jy-=979;}else{gy=621;}var d=365*jy+Math.floor(jy/33)*8+Math.floor((jy%33+3)/4)+78+jd+(jm<7?(jm-1)*31:(jm-7)*30+186);gy+=400*Math.floor(d/146097);d%=146097;if(d>36524){d--;gy+=100*Math.floor(d/36524);d%=36524;if(d>=365)d++;}gy+=4*Math.floor(d/1461);d%=1461;if(d>365){gy+=Math.floor((d-1)/365);d=(d-1)%365;}var gd2=d+1,sa=[0,31,(gy%4===0&&(gy%100!==0||gy%400===0))?29:28,31,30,31,30,31,31,30,31,30,31],gm2=0;for(;gd2>sa[gm2+1];gm2++)gd2-=sa[gm2+1];return[gy,gm2+1,gd2];};
        window._jDIM=function(jy,jm){return jm<=6?31:jm<=11?30:((jy-979)%33%4===0?30:29);};
        window._jDow=function(jy,jm){var g=window._jToG(jy,jm,1);return(new Date(g[0],g[1]-1,g[2]).getDay()+1)%7;};
        window._jNow=function(){var n=new Date();return window._gToJ(n.getFullYear(),n.getMonth()+1,n.getDate());};
    }

    var uid='{{ $uid }}';
    var mn=['فروردین','اردیبهشت','خرداد','تیر','مرداد','شهریور','مهر','آبان','آذر','دی','بهمن','اسفند'];
    var dn=['ش','ی','د','س','چ','پ','ج'];

    // Parse initial state
    var _v='{{ addslashes($val) }}',_p=_v.split('/'),_y=0,_m=0,_d=0;
    if(_p.length===3&&+_p[0]>1300){_y=+_p[0];_m=+_p[1];_d=+_p[2];}
    else{var _t=window._jNow();_y=_t[0];_m=_t[1];}

    window['_fjdp_'+uid]={year:_y,month:_m,day:_d,popEl:null,inpEl:null,hidEl:null};

    function getS(){return window['_fjdp_'+uid];}

    function ensureEls(){
        var s=getS();
        if(!s.inpEl){s.inpEl=document.getElementById('inp'+uid);s.popEl=document.getElementById('pop'+uid);s.hidEl=document.getElementById('hid'+uid);}
        if(s.popEl&&s.popEl.parentNode!==document.body)document.body.appendChild(s.popEl);
    }

    function buildHTML(){
        var s=getS(),t=window._jNow(),fd=window._jDow(s.year,s.month),dim=window._jDIM(s.year,s.month),cells=[];
        for(var i=0;i<fd;i++)cells.push(0);
        for(var d=1;d<=dim;d++)cells.push(d);
        while(cells.length%7!==0)cells.push(0);
        var yO='';for(var y=1380;y<=1420;y++)yO+='<option value="'+y+'"'+(y===s.year?' selected':'')+'>'+y+'</option>';
        var mO='';mn.forEach(function(m,i){mO+='<option value="'+(i+1)+'"'+(i+1===s.month?' selected':'')+'>'+m+'</option>';});
        var btnStyle='padding:5px 7px;border-radius:8px;border:1px solid #e5e7eb;background:#f9fafb;cursor:pointer;display:flex;align-items:center;';
        var selStyle='border:1px solid #d1d5db;border-radius:8px;padding:4px 6px;font-size:12px;font-weight:600;background:#fff;color:#111827;outline:none;cursor:pointer;';
        var h='<div style="display:flex;align-items:center;gap:4px;margin-bottom:10px;">';
        h+='<button type="button" onmousedown="fjdpNav(\''+uid+'\',1)" style="'+btnStyle+'"><svg width="13" height="13" fill="none" stroke="#6b7280" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg></button>';
        h+='<select onmousedown="event.stopPropagation()" onchange="fjdpSetM(\''+uid+'\',this.value)" style="flex:1;'+selStyle+'">'+mO+'</select>';
        h+='<select onmousedown="event.stopPropagation()" onchange="fjdpSetY(\''+uid+'\',this.value)" style="width:68px;'+selStyle+'">'+yO+'</select>';
        h+='<button type="button" onmousedown="fjdpNav(\''+uid+'\',-1)" style="'+btnStyle+'"><svg width="13" height="13" fill="none" stroke="#6b7280" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/></svg></button></div>';
        h+='<div style="display:grid;grid-template-columns:repeat(7,1fr);margin-bottom:4px;">';
        dn.forEach(function(d){h+='<div style="text-align:center;font-size:11px;color:#9ca3af;padding:2px 0;">'+d+'</div>';});
        h+='</div>';
        for(var r=0;r<cells.length/7;r++){
            h+='<div style="display:grid;grid-template-columns:repeat(7,1fr);margin-bottom:2px;">';
            for(var c=0;c<7;c++){
                var cell=cells[r*7+c],isT=cell&&cell===t[2]&&s.month===t[1]&&s.year===t[0],isS=cell&&cell===s.day;
                var cs='width:28px;height:28px;margin:auto;display:flex;align-items:center;justify-content:center;font-size:12px;border-radius:50%;border:none;cursor:pointer;';
                if(!cell)cs+='opacity:0;pointer-events:none;background:transparent;';
                else if(isS)cs+='background:#7c3aed;color:#fff;font-weight:700;';
                else if(isT)cs+='background:#ede9fe;color:#6d28d9;font-weight:600;';
                else cs+='background:transparent;color:#374151;';
                h+='<button type="button" style="'+cs+'"'+(cell?' onmousedown="fjdpPick(\''+uid+'\','+cell+')"':' disabled')+'>'+(cell||'')+'</button>';
            }
            h+='</div>';
        }
        h+='<div style="display:flex;justify-content:space-between;margin-top:8px;padding-top:8px;border-top:1px solid #f3f4f6;">';
        h+='<button type="button" onmousedown="fjdpToday(\''+uid+'\')" style="font-size:12px;color:#7c3aed;background:none;border:none;cursor:pointer;padding:0;">امروز</button>';
        h+='<button type="button" onmousedown="fjdpClear(\''+uid+'\')" style="font-size:12px;color:#f87171;background:none;border:none;cursor:pointer;padding:0;">پاک کردن</button></div>';
        return h;
    }

    window['fjdpToggle']=function(id){
        var s=window['_fjdp_'+id];if(!s)return;
        ensureElsFor(id);
        if(s.popEl.style.display!=='none'){s.popEl.style.display='none';return;}
        s.popEl.innerHTML=buildHTMLFor(id);
        var rect=s.inpEl.getBoundingClientRect(),pw=304,top=rect.bottom+6,left=rect.right-pw;
        if(left<8)left=8;if(left+pw>window.innerWidth-8)left=window.innerWidth-pw-8;
        if(window.innerHeight-rect.bottom<380)top=Math.max(8,rect.top-6-380);
        s.popEl.style.top=top+'px';s.popEl.style.left=left+'px';s.popEl.style.display='block';
    };
    window['fjdpNav']=function(id,d){var s=window['_fjdp_'+id];if(!s)return;s.month+=d;if(s.month>12){s.month=1;s.year++;}if(s.month<1){s.month=12;s.year--;}if(s.popEl){s.popEl.innerHTML=buildHTMLFor(id);}};
    window['fjdpSetM']=function(id,v){var s=window['_fjdp_'+id];if(!s)return;s.month=+v;if(s.popEl)s.popEl.innerHTML=buildHTMLFor(id);};
    window['fjdpSetY']=function(id,v){var s=window['_fjdp_'+id];if(!s)return;s.year=+v;if(s.popEl)s.popEl.innerHTML=buildHTMLFor(id);};
    window['fjdpPick']=function(id,d){
        var s=window['_fjdp_'+id];if(!s)return;
        s.day=d;
        var v=s.year+'/'+String(s.month).padStart(2,'0')+'/'+String(d).padStart(2,'0');
        s.inpEl.value=v;
        if(s.hidEl){s.hidEl.value=v;s.hidEl.dispatchEvent(new Event('input'));s.hidEl.dispatchEvent(new Event('change'));}
        s.popEl.style.display='none';
    };
    window['fjdpToday']=function(id){var t=window._jNow(),s=window['_fjdp_'+id];if(!s)return;s.year=t[0];s.month=t[1];fjdpPick(id,t[2]);};
    window['fjdpClear']=function(id){
        var s=window['_fjdp_'+id];if(!s)return;
        s.inpEl.value='';s.day=0;
        if(s.hidEl){s.hidEl.value='';s.hidEl.dispatchEvent(new Event('input'));s.hidEl.dispatchEvent(new Event('change'));}
        s.popEl.style.display='none';
    };

    function ensureElsFor(id){var s=window['_fjdp_'+id];if(!s.inpEl){s.inpEl=document.getElementById('inp'+id);s.popEl=document.getElementById('pop'+id);s.hidEl=document.getElementById('hid'+id);}if(s.popEl&&s.popEl.parentNode!==document.body)document.body.appendChild(s.popEl);}
    function buildHTMLFor(id){var prev=uid;uid=id;var h=buildHTML();uid=prev;return h;}

    // Outside click close
    document.addEventListener('click',function(e){
        var s=window['_fjdp_'+uid];
        if(!s||!s.popEl||s.popEl.style.display==='none')return;
        var w=document.getElementById('wrap'+uid);
        if(w&&w.contains(e.target))return;
        if(s.popEl.contains(e.target))return;
        s.popEl.style.display='none';
    },true);

    // Ensure elements after DOM ready
    if(document.readyState==='loading')document.addEventListener('DOMContentLoaded',function(){ensureEls();});
    else ensureEls();
})();
</script>

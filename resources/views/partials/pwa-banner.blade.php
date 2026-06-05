@if(\App\Models\Setting::get('pwa_enabled', '1'))
<div id="pwa-install-banner" 
     x-data="{ 
        show: false, 
        deferredPrompt: null,
        isIOS: /iPad|iPhone|iPod/.test(navigator.userAgent) || (navigator.platform === 'MacIntel' && navigator.maxTouchPoints > 1),
        isStandalone: window.matchMedia('(display-mode: standalone)').matches || window.navigator.standalone === true,
        dismissed: localStorage.getItem('pwa_dismissed') === '1',
        
        init() {
            if (this.dismissed || this.isStandalone) return;

            window.addEventListener('beforeinstallprompt', (e) => {
                e.preventDefault();
                this.deferredPrompt = e;
                this.show = true;
            });

            // iOS Safari detection
            const isSafari = /^((?!chrome|android).)*safari/i.test(navigator.userAgent);
            if (this.isIOS && isSafari && !this.isStandalone) {
                setTimeout(() => { this.show = true; }, 3000);
            }
        },
        
        install() {
            if (!this.deferredPrompt) return;
            
            this.deferredPrompt.prompt();
            this.deferredPrompt.userChoice.then((choice) => {
                if (choice.outcome === 'accepted') {
                    this.show = false;
                }
                this.deferredPrompt = null;
            });
        },
        
        dismiss() {
            this.show = false;
            localStorage.setItem('pwa_dismissed', '1');
        }
     }"
     x-show="show"
     x-cloak
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0 translate-y-8"
     x-transition:enter-end="opacity-100 translate-y-0"
     class="fixed bottom-24 left-1/2 -translate-x-1/2 z-[99999] w-[calc(100%-2rem)] max-w-md"
>
    <div class="bg-surface-900/95 dark:bg-surface-800/95 backdrop-blur-xl border border-white/10 rounded-3xl p-4 shadow-2xl flex items-center gap-4">
        <div class="w-12 h-12 rounded-2xl bg-primary-500/20 flex items-center justify-center flex-shrink-0 text-primary-500">
            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/>
            </svg>
        </div>
        
        <div class="flex-1 min-width-0">
            <h4 class="text-white text-sm font-bold truncate">
                <span x-text="isIOS ? 'نصب روی آیفون' : 'نصب اپلیکیشن ' + '{{ \App\Models\Setting::get('pwa_short_name', config('app.name')) }}'"></span>
            </h4>
            <p class="text-surface-400 text-[10px] mt-0.5 truncate">
                <span x-text="isIOS ? 'دکمه Share و سپس Add to Home را بزنید' : 'دسترسی سریع و آفلاین از صفحه اصلی'"></span>
            </p>
        </div>
        
        <div class="flex items-center gap-2 flex-shrink-0">
            <button x-show="!isIOS" @click="install" class="bg-primary-500 hover:bg-primary-600 text-white px-4 py-2 rounded-xl text-xs font-bold transition-colors">
                نصب
            </button>
            <button @click="dismiss" class="text-surface-500 hover:text-surface-300 p-1 transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
    </div>
</div>
@endif

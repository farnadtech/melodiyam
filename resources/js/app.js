import './bootstrap';

// ── Register Alpine plugins & stores ──
// Livewire v4 owns Alpine, so we hook into its lifecycle.
function registerAlpineStuff(Alpine) {
    // ── Global Music Player Store ──
    Alpine.store('player', {
        isPlaying: false,
        currentTrack: null,
        queue: [],
        queueIndex: 0,
        volume: 80,
        isMuted: false,
        isShuffled: false,
        repeatMode: 'off',
        currentTime: 0,
        duration: 0,
        isFullscreen: false,
        isMiniPlayer: true,
        audio: null,
        previewLimitReached: false,

        init() {
            this.audio = new Audio();
            this.audio.volume = this.volume / 100;

            // Load quality preference
            this.quality = localStorage.getItem('playback_quality') || 'auto';
            window.addEventListener('quality-changed', (e) => {
                this.quality = e.detail;
            });

            this.audio.addEventListener('timeupdate', () => {
                this.currentTime = this.audio.currentTime;

                // Preview limit check
                const t = this.currentTrack;
                if (t && t.previewSeconds > 0 && !t.canPlay && this.audio.currentTime >= t.previewSeconds) {
                    this.audio.pause();
                    this.isPlaying = false;
                    this.previewLimitReached = true;
                    if (t.isPremium) {
                        this.showPremiumModal(t);
                    } else {
                        this.showPurchaseModal(t);
                    }
                }
            });

            this.audio.addEventListener('loadedmetadata', () => {
                this.duration = this.audio.duration;
            });

            this.audio.addEventListener('durationchange', () => {
                this.duration = this.audio.duration;
            });

            this.audio.addEventListener('ended', () => {
                this.handleTrackEnd();
            });

            // Record stream when user navigates away or refreshes
            window.addEventListener('beforeunload', () => {
                this.recordStream(false);
            });

            // Periodic recording every 30 seconds for long sessions
            setInterval(() => {
                if (this.isPlaying && this.currentTrack) {
                    this.recordStream(false);
                }
            }, 30000);
        },

        play(track = null) {
            // اگر تبلیغ داره پخش میشه، آهنگ جدید رو نگه دار تا بعد از تبلیغ پخش بشه
            if (window._adCurrentlyPlaying) {
                if (track) window._adPendingTrack = track;
                return;
            }

            if (track) {
                // If premium-only with no preview, show upgrade modal immediately
                if (track.isPremium && !(track.previewSeconds > 0)) {
                    this.showPremiumModal(track);
                    return;
                }

                const prevId = this.currentTrack?.id;
                const isTrackChange = prevId && prevId !== track.id;

                this.currentTrack = track;
                this.previewLimitReached = false;
                if (this.audio) {
                    let streamUrl = track.url;
                    // Append quality param if it's a local stream and quality is set
                    if (streamUrl.includes('/stream/track/')) {
                        const q = localStorage.getItem('playback_quality') || 'auto';
                        if (q !== 'auto') {
                            streamUrl += (streamUrl.includes('?') ? '&' : '?') + 'quality=' + q;
                        }
                    }
                    this.audio.src = streamUrl;
                    this.audio.load();
                }

                // اگر track عوض شد، از ad hook چک کن
                if (isTrackChange && window._adCheckHook) {
                    const shouldBlock = window._adCheckHook(track);
                    if (shouldBlock) return; // ad شروع شد، پخش نکن
                }
            }
            if (this.audio && this.audio.src) {
                this.audio.play().catch(() => {});
            }
            this.isPlaying = true;
        },

        showPurchaseModal(track) {
            const old = document.getElementById('preview-purchase-modal');
            if (old) old.remove();

            const primary = getComputedStyle(document.documentElement).getPropertyValue('--admin-primary').trim() || '#0ea5e9';
            const hasDiscount = track.discountPrice && track.discountPrice !== track.price;
            const price = hasDiscount ? track.discountPrice : track.price;
            const originalPrice = hasDiscount ? track.price : null;
            const purchaseUrl = track.purchaseUrl || '#';

            const modal = document.createElement('div');
            modal.id = 'preview-purchase-modal';
            modal.style.cssText = 'position:fixed;inset:0;z-index:9999;display:flex;align-items:center;justify-content:center;background:rgba(0,0,0,0.6);backdrop-filter:blur(4px);direction:rtl;';
            modal.innerHTML = `
                <div style="background:#1e293b;border-radius:20px;padding:32px;max-width:380px;width:90%;text-align:center;box-shadow:0 25px 60px rgba(0,0,0,.5);border:1px solid rgba(255,255,255,.1);">
                    <div style="width:64px;height:64px;border-radius:50%;background:${primary}26;border:2px solid ${primary}55;display:flex;align-items:center;justify-content:center;margin:0 auto 20px;">
                        <svg width="28" height="28" fill="none" stroke="${primary}" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                    </div>
                    <h3 style="color:#f1f5f9;font-size:18px;font-weight:700;margin-bottom:8px;">پیش‌نمایش به پایان رسید</h3>
                    <p style="color:#94a3b8;font-size:13px;margin-bottom:20px;">برای شنیدن کامل «${track.title}» آهنگ را خریداری کنید</p>
                    <div style="display:flex;align-items:center;justify-content:center;gap:8px;margin-bottom:24px;">
                        ${originalPrice ? `<span style="color:#64748b;text-decoration:line-through;font-size:13px;">${originalPrice.toLocaleString()}</span>` : ''}
                        <span style="color:${primary};font-size:22px;font-weight:800;">${price.toLocaleString()} ت</span>
                    </div>
                    <div style="display:flex;gap:10px;justify-content:center;">
                        <button onclick="document.getElementById('preview-purchase-modal').remove()" style="padding:10px 20px;border-radius:10px;background:#334155;color:#cbd5e1;font-size:13px;cursor:pointer;border:none;">بستن</button>
                        <a href="${purchaseUrl}" style="padding:10px 24px;border-radius:10px;background:${primary};color:#fff;font-size:13px;font-weight:600;text-decoration:none;display:inline-flex;align-items:center;gap:6px;">
                            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                            خرید آهنگ
                        </a>
                    </div>
                </div>`;
            document.body.appendChild(modal);
            modal.addEventListener('click', (e) => { if (e.target === modal) modal.remove(); });
        },

        showPremiumModal(track) {
            const old = document.getElementById('preview-premium-modal');
            if (old) old.remove();
            const primary = getComputedStyle(document.documentElement).getPropertyValue('--admin-primary').trim() || '#0ea5e9';
            const purchaseUrl = track.purchaseUrl || '/premium';
            const modal = document.createElement('div');
            modal.id = 'preview-premium-modal';
            modal.style.cssText = 'position:fixed;inset:0;z-index:9999;display:flex;align-items:center;justify-content:center;background:rgba(0,0,0,0.6);backdrop-filter:blur(4px);direction:rtl;';
            modal.innerHTML = `
                <div style="background:#1e293b;border-radius:20px;padding:32px;max-width:380px;width:90%;text-align:center;box-shadow:0 25px 60px rgba(0,0,0,.5);border:1px solid ${primary}44;">
                    <div style="width:64px;height:64px;border-radius:50%;background:${primary}26;border:2px solid ${primary}66;display:flex;align-items:center;justify-content:center;margin:0 auto 20px;">
                        <svg width="28" height="28" fill="${primary}" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                    </div>
                    <h3 style="color:#f1f5f9;font-size:18px;font-weight:700;margin-bottom:8px;">پیش‌نمایش به پایان رسید</h3>
                    <p style="color:#94a3b8;font-size:13px;margin-bottom:24px;">برای شنیدن کامل «${track.title}» اشتراک پریمیوم تهیه کنید</p>
                    <div style="display:flex;gap:10px;justify-content:center;">
                        <button onclick="document.getElementById('preview-premium-modal').remove()" style="padding:10px 20px;border-radius:10px;background:#334155;color:#cbd5e1;font-size:13px;cursor:pointer;border:none;">بستن</button>
                        <a href="${purchaseUrl}" style="padding:10px 24px;border-radius:10px;background:${primary};color:#fff;font-size:13px;font-weight:600;text-decoration:none;display:inline-flex;align-items:center;gap:6px;">
                            <svg width="14" height="14" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                            ارتقا به پریمیوم
                        </a>
                    </div>
                </div>`;
            document.body.appendChild(modal);
            modal.addEventListener('click', (e) => { if (e.target === modal) modal.remove(); });
        },

        recordStream(completed = false) {
            if (!this.currentTrack) return;
            const listened = Math.floor(this.currentTime);
            // Only record if listened at least 3 seconds
            if (listened < 3) return;

            const csrf = document.querySelector('meta[name="csrf-token"]')?.content;
            // Only record for authenticated users (csrf token exists)
            if (!csrf) return;

            console.log('Recording stream:', this.currentTrack.id, 'listened:', listened, 'completed:', completed);

            const payload = {
                duration_listened: listened,
                completed: completed
            };

            // Handle both tracks and podcast episodes
            const idStr = String(this.currentTrack.id);
            if (idStr.startsWith('episode-')) {
                payload.episode_id = idStr.replace('episode-', '');
            } else {
                payload.track_id = idStr;
            }

            fetch('/stream/record', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrf
                },
                body: JSON.stringify(payload)
            }).catch(() => {});
        },

        pause() {
            if (this.audio) this.audio.pause();
            this.isPlaying = false;
        },

        stop() {
            this.recordStream(false);
            if (this.audio) {
                this.audio.pause();
                this.audio.src = '';
            }
            this.isPlaying = false;
            this.currentTrack = null;
            this.currentTime = 0;
            this.duration = 0;
            this.queue = [];
            this.queueIndex = 0;
        },

        toggle() {
            this.isPlaying ? this.pause() : this.play();
        },

        seek(time) {
            if (this.audio && !isNaN(time) && isFinite(time) && time >= 0) {
                this.audio.currentTime = Math.min(time, this.audio.duration || Infinity);
            }
        },

        setVolume(vol) {
            this.volume = vol;
            if (this.audio) this.audio.volume = vol / 100;
            this.isMuted = vol === 0;
        },

        toggleMute() {
            this.isMuted = !this.isMuted;
            if (this.audio) this.audio.muted = this.isMuted;
        },

        next() {
            this.recordStream(false);
            if (this.queue.length === 0) return;
            if (this.isShuffled) {
                this.queueIndex = Math.floor(Math.random() * this.queue.length);
            } else {
                this.queueIndex = (this.queueIndex + 1) % this.queue.length;
            }
            const track = this.queue[this.queueIndex];
            // If ad is playing, set pending track
            if (window._adCurrentlyPlaying) {
                window._adPendingTrack = track;
                return;
            }
            this.play(track);
        },

        previous() {
            if (this.currentTime > 3) {
                this.seek(0);
                return;
            }
            this.recordStream(false);
            if (this.queue.length === 0) return;
            this.queueIndex = (this.queueIndex - 1 + this.queue.length) % this.queue.length;
            const track = this.queue[this.queueIndex];
            // If ad is playing, set pending track
            if (window._adCurrentlyPlaying) {
                window._adPendingTrack = track;
                return;
            }
            this.play(track);
        },

        handleTrackEnd() {
            this.recordStream(true);
            switch (this.repeatMode) {
                case 'one':
                    this.seek(0);
                    if (this.audio) this.audio.play();
                    break;
                case 'all':
                    this.next();
                    break;
                default:
                    if (this.queueIndex < this.queue.length - 1) {
                        this.next();
                    } else {
                        this.isPlaying = false;
                    }
            }
        },

        toggleRepeat() {
            const modes = ['off', 'all', 'one'];
            const idx = modes.indexOf(this.repeatMode);
            this.repeatMode = modes[(idx + 1) % modes.length];
        },

        toggleShuffle() {
            this.isShuffled = !this.isShuffled;
        },

        addToQueue(track) {
            this.queue.push(track);
        },

        playQueue(tracks, startIndex = 0) {
            this.queue = tracks;
            this.queueIndex = startIndex;
            this.play(tracks[startIndex]);
        },

        get progress() {
            return (this.duration && this.duration > 0) ? (this.currentTime / this.duration) * 100 : 0;
        },

        get formattedCurrentTime() {
            return this.formatTime(this.currentTime);
        },

        get formattedDuration() {
            return this.formatTime(this.duration);
        },

        formatTime(seconds) {
            const m = Math.floor(seconds / 60);
            const s = Math.floor(seconds % 60);
            return `${m}:${s.toString().padStart(2, '0')}`;
        }
    });

    // ── Theme Store ──
    Alpine.store('theme', {
        dark: (() => {
            const stored = localStorage.getItem('theme_dark');
            return stored === null ? true : stored === 'true';
        })(),

        init() {
            // Ensure DOM matches stored preference on every page load/navigate
            document.documentElement.classList.toggle('dark', this.dark);
        },

        toggle() {
            this.dark = !this.dark;
            localStorage.setItem('theme_dark', this.dark);
            document.documentElement.classList.toggle('dark', this.dark);
        }
    });
    // ── Global Events ──
    window.addEventListener('play-track', (e) => {
        Alpine.store('player').play(e.detail);
    });
}

// ── Drag-to-scroll directive ──
function registerDragScroll(Alpine) {
    Alpine.directive('drag-scroll', (el) => {
        let isDown = false;
        let startX;
        let scrollLeft;

        el.addEventListener('mousedown', (e) => {
            isDown = true;
            el.classList.add('cursor-grabbing', 'select-none');
            startX = e.pageX - el.offsetLeft;
            scrollLeft = el.scrollLeft;
        });

        el.addEventListener('mouseleave', () => {
            isDown = false;
            el.classList.remove('cursor-grabbing', 'select-none');
        });

        el.addEventListener('mouseup', () => {
            isDown = false;
            el.classList.remove('cursor-grabbing', 'select-none');
        });

        el.addEventListener('mousemove', (e) => {
            if (!isDown) return;
            e.preventDefault();
            const x = e.pageX - el.offsetLeft;
            const walk = (x - startX) * 1.5;
            el.scrollLeft = scrollLeft - walk;
        });
    });
}

// Try multiple hooks to ensure stores get registered regardless of load order
document.addEventListener('alpine:init', () => {
    if (window.Alpine) {
        registerAlpineStuff(window.Alpine);
        registerDragScroll(window.Alpine);
    }
});

// Fallback: if Alpine already started before our module loaded
if (window.Alpine) {
    registerAlpineStuff(window.Alpine);
    registerDragScroll(window.Alpine);
}

// Re-sync theme after Livewire page navigations
document.addEventListener('livewire:navigated', () => {
    const dark = localStorage.getItem('theme_dark');
    const isDark = dark === null ? true : dark === 'true';
    document.documentElement.classList.toggle('dark', isDark);
});

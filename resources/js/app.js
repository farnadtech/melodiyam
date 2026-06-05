import './bootstrap';
import { escapeHtml, isSafeUrl, sanitizeTrack, getCsrfToken } from './security';
import { registerWaveform } from './waveform';
import { registerTrackPage } from './track-page';

const AUDIO_SINGLETON_KEY = '__melodiyamPlayerAudio';
let _alpineRegistered = false;
let _dragScrollRegistered = false;

function getPlayerAudio() {
    if (!window[AUDIO_SINGLETON_KEY]) {
        window[AUDIO_SINGLETON_KEY] = new Audio();
        window[AUDIO_SINGLETON_KEY].setAttribute('data-melodiyam-player', '1');
    }
    return window[AUDIO_SINGLETON_KEY];
}

function stopAllOtherAudio(except) {
    document.querySelectorAll('audio').forEach(el => {
        if (el === except) return;
        if (!el.paused) {
            el.pause();
            try { el.currentTime = 0; } catch { /* ignore */ }
        }
    });
}

function ensureSinglePlayerDom() {
    const bars = document.querySelectorAll('#global-player-bar');
    if (bars.length <= 1) return;
    for (let i = 1; i < bars.length; i++) {
        const wrapper = bars[i].closest('#global-player-wrapper');
        if (wrapper) wrapper.remove();
    }
}

function registerAlpineStuff(Alpine) {
    if (_alpineRegistered) return;
    _alpineRegistered = true;

    registerWaveform(Alpine);
    registerTrackPage(Alpine);

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
        _bound: false,

        init() {
            this.audio = getPlayerAudio();
            this.audio.volume = this.volume / 100;

            if (this._bound) return;
            this._bound = true;

            this.quality = localStorage.getItem('playback_quality') || 'auto';
            window.addEventListener('quality-changed', (e) => {
                this.quality = e.detail;
            });

            this.audio.addEventListener('timeupdate', () => {
                this.currentTime = this.audio.currentTime;

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

                if (this.currentTrack && this.duration > 0) {
                    const trackId = String(this.currentTrack.id);
                    if (!trackId.startsWith('episode-')) {
                        const stored = this.currentTrack.duration;
                        if (!stored || stored <= 0) {
                            const csrf = getCsrfToken();
                            if (!csrf) return;
                            const url = '/api/track/' + encodeURIComponent(trackId) + '/fix-duration';
                            fetch(url, {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'Accept': 'application/json',
                                    'X-CSRF-TOKEN': csrf,
                                },
                                body: JSON.stringify({ duration: Math.round(this.duration) })
                            }).catch(() => {});
                        }
                    }
                }
            });

            this.audio.addEventListener('durationchange', () => {
                this.duration = this.audio.duration;
            });

            this.audio.addEventListener('ended', () => {
                this.handleTrackEnd();
            });

            window.addEventListener('beforeunload', () => {
                this.recordStream(false);
            });

            setInterval(() => {
                if (this.isPlaying && this.currentTrack) {
                    this.recordStream(false);
                }
            }, 30000);
        },

        play(track = null) {
            if (window._adCurrentlyPlaying) {
                if (track) window._adPendingTrack = sanitizeTrack(track);
                return;
            }

            if (track) {
                const safe = sanitizeTrack(track);
                if (!safe || !safe.url) return;

                if (safe.isPremium && !(safe.previewSeconds > 0)) {
                    this.showPremiumModal(safe);
                    return;
                }

                const prevId = this.currentTrack?.id;
                const isTrackChange = !prevId || String(prevId) !== String(safe.id);

                if (isTrackChange) {
                    stopAllOtherAudio(this.audio);
                    if (this.audio) {
                        this.audio.pause();
                        this.audio.currentTime = 0;
                    }
                }

                this.currentTrack = safe;
                this.previewLimitReached = false;

                if (safe.duration && safe.duration > 0) {
                    this.duration = safe.duration;
                } else {
                    this.duration = 0;
                }

                if (this.audio) {
                    let streamUrl = safe.url;
                    if (streamUrl.includes('/stream/track/')) {
                        const q = localStorage.getItem('playback_quality') || 'auto';
                        if (q !== 'auto') {
                            streamUrl += (streamUrl.includes('?') ? '&' : '?') + 'quality=' + encodeURIComponent(q);
                        }
                    }
                    this.audio.src = streamUrl;
                    this.audio.load();
                }

                if (isTrackChange && window._adCheckHook) {
                    const shouldBlock = window._adCheckHook(safe);
                    if (shouldBlock) return;
                }
            }

            if (this.audio && this.audio.src) {
                stopAllOtherAudio(this.audio);
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
            const purchaseUrl = track.purchaseUrl && isSafeUrl(track.purchaseUrl) ? track.purchaseUrl : '#';
            const title = escapeHtml(track.title);

            const modal = document.createElement('div');
            modal.id = 'preview-purchase-modal';
            modal.style.cssText = 'position:fixed;inset:0;z-index:9999;display:flex;align-items:center;justify-content:center;background:rgba(0,0,0,0.6);backdrop-filter:blur(4px);direction:rtl;';

            const card = document.createElement('div');
            card.style.cssText = 'background:#1e293b;border-radius:20px;padding:32px;max-width:380px;width:90%;text-align:center;box-shadow:0 25px 60px rgba(0,0,0,.5);border:1px solid rgba(255,255,255,.1);';

            const heading = document.createElement('h3');
            heading.style.cssText = 'color:#f1f5f9;font-size:18px;font-weight:700;margin-bottom:8px;';
            heading.textContent = 'پیش‌نمایش به پایان رسید';

            const desc = document.createElement('p');
            desc.style.cssText = 'color:#94a3b8;font-size:13px;margin-bottom:20px;';
            desc.textContent = 'برای شنیدن کامل «' + (track.title || '') + '» آهنگ را خریداری کنید';

            const priceWrap = document.createElement('div');
            priceWrap.style.cssText = 'display:flex;align-items:center;justify-content:center;gap:8px;margin-bottom:24px;';
            if (originalPrice) {
                const orig = document.createElement('span');
                orig.style.cssText = 'color:#64748b;text-decoration:line-through;font-size:13px;';
                orig.textContent = Number(originalPrice).toLocaleString();
                priceWrap.appendChild(orig);
            }
            const priceEl = document.createElement('span');
            priceEl.style.cssText = 'color:' + primary + ';font-size:22px;font-weight:800;';
            priceEl.textContent = Number(price).toLocaleString() + ' ت';
            priceWrap.appendChild(priceEl);

            const actions = document.createElement('div');
            actions.style.cssText = 'display:flex;gap:10px;justify-content:center;';

            const closeBtn = document.createElement('button');
            closeBtn.type = 'button';
            closeBtn.style.cssText = 'padding:10px 20px;border-radius:10px;background:#334155;color:#cbd5e1;font-size:13px;cursor:pointer;border:none;';
            closeBtn.textContent = 'بستن';
            closeBtn.addEventListener('click', () => modal.remove());

            const buyLink = document.createElement('a');
            buyLink.href = purchaseUrl;
            buyLink.style.cssText = 'padding:10px 24px;border-radius:10px;background:' + primary + ';color:#fff;font-size:13px;font-weight:600;text-decoration:none;display:inline-flex;align-items:center;gap:6px;';
            buyLink.textContent = 'خرید آهنگ';

            actions.appendChild(closeBtn);
            actions.appendChild(buyLink);
            card.appendChild(heading);
            card.appendChild(desc);
            card.appendChild(priceWrap);
            card.appendChild(actions);
            modal.appendChild(card);
            document.body.appendChild(modal);
            modal.addEventListener('click', (e) => { if (e.target === modal) modal.remove(); });
        },

        showPremiumModal(track) {
            const old = document.getElementById('preview-premium-modal');
            if (old) old.remove();

            const primary = getComputedStyle(document.documentElement).getPropertyValue('--admin-primary').trim() || '#0ea5e9';
            const purchaseUrl = track.purchaseUrl && isSafeUrl(track.purchaseUrl) ? track.purchaseUrl : '/premium';

            const modal = document.createElement('div');
            modal.id = 'preview-premium-modal';
            modal.style.cssText = 'position:fixed;inset:0;z-index:9999;display:flex;align-items:center;justify-content:center;background:rgba(0,0,0,0.6);backdrop-filter:blur(4px);direction:rtl;';

            const card = document.createElement('div');
            card.style.cssText = 'background:#1e293b;border-radius:20px;padding:32px;max-width:380px;width:90%;text-align:center;box-shadow:0 25px 60px rgba(0,0,0,.5);border:1px solid ' + primary + '44;';

            const heading = document.createElement('h3');
            heading.style.cssText = 'color:#f1f5f9;font-size:18px;font-weight:700;margin-bottom:8px;';
            heading.textContent = 'پیش‌نمایش به پایان رسید';

            const desc = document.createElement('p');
            desc.style.cssText = 'color:#94a3b8;font-size:13px;margin-bottom:24px;';
            desc.textContent = 'برای شنیدن کامل «' + (track.title || '') + '» اشتراک پریمیوم تهیه کنید';

            const actions = document.createElement('div');
            actions.style.cssText = 'display:flex;gap:10px;justify-content:center;';

            const closeBtn = document.createElement('button');
            closeBtn.type = 'button';
            closeBtn.style.cssText = 'padding:10px 20px;border-radius:10px;background:#334155;color:#cbd5e1;font-size:13px;cursor:pointer;border:none;';
            closeBtn.textContent = 'بستن';
            closeBtn.addEventListener('click', () => modal.remove());

            const upgradeLink = document.createElement('a');
            upgradeLink.href = purchaseUrl;
            upgradeLink.style.cssText = 'padding:10px 24px;border-radius:10px;background:' + primary + ';color:#fff;font-size:13px;font-weight:600;text-decoration:none;display:inline-flex;align-items:center;gap:6px;';
            upgradeLink.textContent = 'ارتقا به پریمیوم';

            actions.appendChild(closeBtn);
            actions.appendChild(upgradeLink);
            card.appendChild(heading);
            card.appendChild(desc);
            card.appendChild(actions);
            modal.appendChild(card);
            document.body.appendChild(modal);
            modal.addEventListener('click', (e) => { if (e.target === modal) modal.remove(); });
        },

        recordStream(completed = false) {
            if (!this.currentTrack) return;
            const listened = Math.floor(this.currentTime);
            if (listened < 3) return;

            const csrf = getCsrfToken();
            if (!csrf) return;

            const payload = {
                duration_listened: listened,
                completed: completed
            };

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
            const safe = Math.max(0, Math.min(100, Number(vol) || 0));
            this.volume = safe;
            if (this.audio) this.audio.volume = safe / 100;
            this.isMuted = safe === 0;
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
            const safe = sanitizeTrack(track);
            if (safe) this.queue.push(safe);
        },

        playQueue(tracks, startIndex = 0) {
            this.queue = (Array.isArray(tracks) ? tracks : [])
                .map(sanitizeTrack)
                .filter(Boolean);
            this.queueIndex = Math.max(0, Math.min(startIndex, this.queue.length - 1));
            if (this.queue.length) this.play(this.queue[this.queueIndex]);
        },

        get progress() {
            return (this.duration && this.duration > 0) ? (this.currentTime / this.duration) * 100 : 0;
        },

        get formattedCurrentTime() {
            return this.formatTime(this.currentTime);
        },

        get formattedDuration() {
            return (this.duration && this.duration > 0) ? this.formatTime(this.duration) : '--:--';
        },

        formatTime(seconds) {
            const m = Math.floor(seconds / 60);
            const s = Math.floor(seconds % 60);
            return `${m}:${s.toString().padStart(2, '0')}`;
        }
    });

    Alpine.store('theme', {
        dark: (() => {
            const stored = localStorage.getItem('theme_dark');
            return stored === null ? true : stored === 'true';
        })(),

        init() {
            document.documentElement.classList.toggle('dark', this.dark);
        },

        toggle() {
            this.dark = !this.dark;
            localStorage.setItem('theme_dark', this.dark);
            document.documentElement.classList.toggle('dark', this.dark);
        }
    });

    window.addEventListener('play-track', (e) => {
        const track = sanitizeTrack(e.detail);
        if (track) Alpine.store('player').play(track);
    });
}

function registerDragScroll(Alpine) {
    if (_dragScrollRegistered) return;
    _dragScrollRegistered = true;

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

function bootAlpine(Alpine) {
    registerAlpineStuff(Alpine);
    registerDragScroll(Alpine);
}

document.addEventListener('alpine:init', () => {
    if (window.Alpine) bootAlpine(window.Alpine);
});

if (window.Alpine) {
    bootAlpine(window.Alpine);
}

function fixMobileLayout() {
    const header = document.getElementById('app-header');
    if (header) {
        header.style.transform = 'translateZ(0)';
        void header.offsetHeight;
    }
}

document.addEventListener('livewire:navigated', () => {
    const dark = localStorage.getItem('theme_dark');
    const isDark = dark === null ? true : dark === 'true';
    document.documentElement.classList.toggle('dark', isDark);
    ensureSinglePlayerDom();
    fixMobileLayout();

    if (window.Alpine) {
        document.querySelectorAll('[x-data^="waveform"]').forEach(el => {
            if (el._x_dataStack && el._x_dataStack.length > 0) return;
            Alpine.initTree(el);
        });
    }
});

window.addEventListener('pageshow', (e) => {
    if (e.persisted) {
        fixMobileLayout();
        const dark = localStorage.getItem('theme_dark');
        const isDark = dark === null ? true : dark === 'true';
        document.documentElement.classList.toggle('dark', isDark);
    }
});

document.addEventListener('visibilitychange', () => {
    if (document.visibilityState === 'visible') {
        fixMobileLayout();
    }
});

window.showDemoToast = function(msg) {
    const safeMsg = String(msg || 'شما در حالت نمایشی (دمو) هستید و امکان ایجاد تغییرات را ندارید.').slice(0, 500);
    window.dispatchEvent(new CustomEvent('flash-message', {
        detail: { message: safeMsg, type: 'error' }
    }));
};

window.addEventListener('demo-blocked', function(e) {
    window.showDemoToast(e.detail?.message || e.detail?.params?.message);
});

const _origFetch = window.fetch;
window.fetch = function(input, init) {
    let url = input;
    if (typeof input === 'string') {
        if (input.startsWith('//')) return Promise.reject(new Error('Blocked URL'));
    } else if (input instanceof Request) {
        url = input.url;
    }
    if (typeof url === 'string' && /^https?:\/\//i.test(url)) {
        try {
            const parsed = new URL(url, window.location.origin);
            if (parsed.origin !== window.location.origin) {
                return _origFetch.apply(this, arguments);
            }
        } catch {
            return Promise.reject(new Error('Invalid URL'));
        }
    }
    return _origFetch.apply(this, arguments).then(function(response) {
        if (response.status === 403 && response.headers.get('X-Demo-Blocked') === '1') {
            window.showDemoToast();
        }
        return response;
    });
};

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

        init() {
            this.audio = new Audio();
            this.audio.volume = this.volume / 100;

            this.audio.addEventListener('timeupdate', () => {
                this.currentTime = this.audio.currentTime;
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

            // Record stream when Livewire navigates (SPA navigation)
            document.addEventListener('livewire:navigating', () => {
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
            if (track) {
                this.currentTrack = track;
                if (this.audio) this.audio.src = track.url;
            }
            if (this.audio && this.audio.src) {
                this.audio.play().catch(() => {});
            }
            this.isPlaying = true;
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

            fetch('/stream/record', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrf
                },
                body: JSON.stringify({
                    track_id: this.currentTrack.id,
                    duration_listened: listened,
                    completed: completed
                })
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
            this.play(this.queue[this.queueIndex]);
        },

        previous() {
            if (this.currentTime > 3) {
                this.seek(0);
                return;
            }
            this.recordStream(false);
            if (this.queue.length === 0) return;
            this.queueIndex = (this.queueIndex - 1 + this.queue.length) % this.queue.length;
            this.play(this.queue[this.queueIndex]);
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
}

// Try multiple hooks to ensure stores get registered regardless of load order
document.addEventListener('alpine:init', () => {
    if (window.Alpine) registerAlpineStuff(window.Alpine);
});

// Fallback: if Alpine already started before our module loaded
if (window.Alpine) {
    registerAlpineStuff(window.Alpine);
}

// Re-sync theme after Livewire page navigations
document.addEventListener('livewire:navigated', () => {
    const dark = localStorage.getItem('theme_dark');
    const isDark = dark === null ? true : dark === 'true';
    document.documentElement.classList.toggle('dark', isDark);
});

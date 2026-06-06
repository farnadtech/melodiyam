import { isSafeUrl } from './security';

let _waveformRegistered = false;

export function registerWaveform(Alpine) {
    if (_waveformRegistered) return;
    _waveformRegistered = true;

    Alpine.data('waveform', (audioUrl, trackId, timedCommentsData, pregeneratedPeaks) => ({
        peaks: pregeneratedPeaks || [],
        currentTime: 0,
        duration: 0,
        progress: 0,
        isThisTrack: false,
        animFrame: null,
        timedComments: timedCommentsData || [],
        groupedMarkers: [],
        activeComment: null,
        lastCheckedSecond: -1,
        openMarker: null,
        openMarkerLabel: '',
        isWaveDrawn: false,
        _trackId: trackId,
        _audioUrl: audioUrl,

        async init() {
            this.updateMarkers();
            this.$watch('openMarker', () => this.updateMarkerLabel());
            
            const phpDuration = parseInt(this.$el.dataset.phpDuration || '0', 10);
            if (phpDuration > 0) this.duration = phpDuration;

            if (this.peaks && this.peaks.length > 0) {
                // Pre-generated
                this.$nextTick(() => this.drawWaveFromContext());
            } else {
                // Server-side generation failed or not available (shell_exec disabled)
                // We MUST generate on client-side
                if (isSafeUrl(this._audioUrl)) {
                    console.log(`[Waveform] Attempting client-side generation for ${this._audioUrl}`);
                    this.generatePeaks(this._audioUrl).then(() => {
                        if (!this.peaks || this.peaks.length === 0) {
                            console.warn('[Waveform] Client-side generation produced no peaks, using fake peaks.');
                            this.generateFakePeaks();
                        }
                        this.drawWaveFromContext();
                    }).catch((err) => {
                        console.error('[Waveform] Client-side generation failed:', err);
                        this.generateFakePeaks();
                        this.drawWaveFromContext();
                    });
                } else {
                    console.warn('[Waveform] URL not safe for client-side generation, using fake peaks.');
                    this.generateFakePeaks();
                    this.drawWaveFromContext();
                }
            }

            this.tick();
        },

        updateMarkers() {
            const groups = {};
            (this.timedComments || []).forEach(tc => {
                if (!groups[tc.at]) groups[tc.at] = [];
                groups[tc.at].push(tc);
            });
            const sorted = Object.entries(groups)
                .map(([sec, items]) => ({ at: parseInt(sec), items, count: items.length }))
                .sort((a, b) => a.at - b.at);

            const merged = [];
            for (const g of sorted) {
                const last = merged[merged.length - 1];
                if (last && Math.abs(g.at - last.at) <= 3) {
                    last.items = last.items.concat(g.items);
                    last.count = last.items.length;
                    last.seconds = last.seconds || [last.at];
                    if (!last.seconds.includes(g.at)) last.seconds.push(g.at);
                } else {
                    g.seconds = [g.at];
                    merged.push({ ...g });
                }
            }
            this.groupedMarkers = merged;
            this.updateMarkerLabel();
        },

        updateMarkerLabel() {
            if (this.openMarker === null) {
                this.openMarkerLabel = '';
                return;
            }
            if (!this.groupedMarkers) {
                this.openMarkerLabel = this.formatTime(this.openMarker);
                return;
            }
            const m = this.groupedMarkers.find(g => g.at === this.openMarker);
            if (!m || !m.seconds || m.seconds.length <= 1) {
                this.openMarkerLabel = this.formatTime(this.openMarker);
                return;
            }
            const sorted = [...m.seconds].sort((a, b) => a - b);
            this.openMarkerLabel = this.formatTime(sorted[0]) + ' - ' + this.formatTime(sorted[sorted.length - 1]);
        },

        generateFakePeaks() {
            // Generate a consistent but random-looking waveform
            // Use trackId as seed if possible for consistency across reloads
            const seed = parseInt(this._trackId) || Math.random();
            const pseudoRandom = (i) => {
                const x = Math.sin(seed + i) * 10000;
                return x - Math.floor(x);
            };
            this.peaks = Array.from({ length: 200 }, (_, i) => 0.2 + pseudoRandom(i) * 0.8);
        },

        drawWaveFromContext() {
            const isDark = document.documentElement.classList.contains('dark');
            this.drawWave(this.$refs.waveCanvas, isDark ? 'rgba(148,163,184,0.3)' : 'rgba(100,116,139,0.3)', isDark ? 'rgba(148,163,184,0.12)' : 'rgba(100,116,139,0.12)');
        },

        async generatePeaks(url) {
            const phpDur = parseInt(this.$el.dataset.phpDuration || '0', 10);
            try {
                const resp = await fetch(url, { credentials: 'same-origin' });
                if (!resp.ok) throw new Error('fetch failed');
                const buf = await resp.arrayBuffer();
                const ctx = new (window.AudioContext || window.webkitAudioContext)();
                const audio = await ctx.decodeAudioData(buf);
                await ctx.close();
                const raw = audio.getChannelData(0);
                const samples = 200;
                const blockSize = Math.floor(raw.length / samples);
                const peaks = [];
                for (let i = 0; i < samples; i++) {
                    let sum = 0;
                    for (let j = 0; j < blockSize; j++) {
                        sum += Math.abs(raw[i * blockSize + j]);
                    }
                    peaks.push(sum / blockSize);
                }
                const max = Math.max(...peaks);
                this.peaks = peaks.map(p => p / max);
                this.drawWaveFromContext();
                this.duration = audio.duration;
                this.positionPreviewMarker(audio.duration);
            } catch {
                this.peaks = Array.from({ length: 200 }, () => 0.2 + Math.random() * 0.8);
                if (phpDur > 0) this.positionPreviewMarker(phpDur);
            }
        },

        positionPreviewMarker(totalDuration) {
            const previewSec = parseInt(this.$el.dataset.previewSec || '0', 10);
            const marker = this.$refs.previewMarker;
            if (!marker || previewSec <= 0 || totalDuration <= 0) return;
            const rightPct = (previewSec / totalDuration) * 100;
            marker.style.right = rightPct + '%';
            marker.style.left = 'auto';
            marker.classList.remove('hidden');
        },

        drawWave(canvas, fillTop, fillBottom) {
            if (!canvas || !canvas.parentElement || !this.peaks || this.peaks.length === 0) return;
            const dpr = window.devicePixelRatio || 1;
            const rect = canvas.parentElement.getBoundingClientRect();
            canvas.width = rect.width * dpr;
            canvas.height = rect.height * dpr;
            canvas.style.width = rect.width + 'px';
            canvas.style.height = rect.height + 'px';
            const ctx = canvas.getContext('2d');
            ctx.scale(dpr, dpr);
            ctx.clearRect(0, 0, rect.width, rect.height);
            this.isWaveDrawn = true;
            const barW = Math.max(2, (rect.width / this.peaks.length) - 1);
            const gap = (rect.width - barW * this.peaks.length) / (this.peaks.length - 1);
            const mid = rect.height / 2;
            this.peaks.forEach((peak, i) => {
                const x = rect.width - (i * (barW + gap)) - barW;
                const h = Math.max(2, peak * (mid - 2));
                ctx.fillStyle = fillTop;
                
                if (ctx.roundRect) {
                    ctx.beginPath();
                    ctx.roundRect(x, mid - h, barW, h, barW / 2);
                    ctx.fill();
                    ctx.fillStyle = fillBottom;
                    ctx.beginPath();
                    ctx.roundRect(x, mid + 1, barW, h * 0.6, barW / 2);
                    ctx.fill();
                } else {
                    // Fallback for older browsers
                    ctx.fillRect(x, mid - h, barW, h);
                    ctx.fillStyle = fillBottom;
                    ctx.fillRect(x, mid + 1, barW, h * 0.6);
                }
            });
        },

        drawProgress() {
            const canvas = this.$refs.waveProgress;
            if (!canvas || !canvas.parentElement || !this.peaks || this.peaks.length === 0) return;
            const dpr = window.devicePixelRatio || 1;
            const rect = canvas.parentElement.getBoundingClientRect();
            canvas.width = rect.width * dpr;
            canvas.height = rect.height * dpr;
            canvas.style.width = rect.width + 'px';
            canvas.style.height = rect.height + 'px';
            const ctx = canvas.getContext('2d');
            ctx.scale(dpr, dpr);
            ctx.clearRect(0, 0, rect.width, rect.height);
            const barW = Math.max(2, (rect.width / this.peaks.length) - 1);
            const gap = (rect.width - barW * this.peaks.length) / (this.peaks.length - 1);
            const mid = rect.height / 2;
            const pct = this.progress / 100;
            const playedBars = Math.floor(this.peaks.length * pct);
            const primary = getComputedStyle(document.documentElement).getPropertyValue('--admin-primary').trim() || '#0ea5e9';
            for (let i = 0; i < playedBars; i++) {
                const x = rect.width - (i * (barW + gap)) - barW;
                const h = Math.max(2, this.peaks[i] * (mid - 2));
                ctx.fillStyle = primary;
                
                if (ctx.roundRect) {
                    ctx.beginPath();
                    ctx.roundRect(x, mid - h, barW, h, barW / 2);
                    ctx.fill();
                    ctx.fillStyle = primary + '99';
                    ctx.beginPath();
                    ctx.roundRect(x, mid + 1, barW, h * 0.6, barW / 2);
                    ctx.fill();
                } else {
                    ctx.fillRect(x, mid - h, barW, h);
                    ctx.fillStyle = primary + '99';
                    ctx.fillRect(x, mid + 1, barW, h * 0.6);
                }
            }
        },

        pickWeightedRandom(candidates) {
            if (candidates.length === 1) return candidates[0];
            const weights = candidates.map(c => (c.likes || 0) + 1);
            const total = weights.reduce((a, b) => a + b, 0);
            let r = Math.random() * total;
            for (let i = 0; i < candidates.length; i++) {
                r -= weights[i];
                if (r <= 0) return candidates[i];
            }
            return candidates[candidates.length - 1];
        },

        checkTimedComments() {
            const t = Math.floor(this.currentTime);
            if (this.lastCheckedSecond === t) return;
            this.lastCheckedSecond = t;

            const candidates = this.timedComments.filter(tc => tc.at === t);
            if (candidates.length === 0) return;

            const picked = this.pickWeightedRandom(candidates);
            this.activeComment = picked;
            setTimeout(() => {
                if (this.activeComment && this.activeComment.id === picked.id) {
                    this.activeComment = null;
                }
            }, 3000);
        },

        tick() {
            if (!this.$refs.waveProgress) {
                if (this.animFrame) cancelAnimationFrame(this.animFrame);
                return;
            }
            const phpDuration = parseInt(this.$el.dataset.phpDuration || '0', 10);
            const store = Alpine.store('player');
            this.isThisTrack = store.currentTrack && store.currentTrack.id === this._trackId;
            if (this.isThisTrack && store.audio) {
                this.currentTime = store.audio.currentTime || 0;
                const audioDur = store.audio.duration;
                this.duration = (audioDur && isFinite(audioDur) && audioDur > 1) ? audioDur : (phpDuration || this.duration);
                this.progress = this.duration > 0 ? (this.currentTime / this.duration) * 100 : 0;
                this.drawProgress();
                this.checkTimedComments();
            } else if (this.progress !== 0) {
                this.currentTime = 0;
                this.progress = 0;
                this.drawProgress();
            }
            this.animFrame = requestAnimationFrame(() => this.tick());

            if (!this.isWaveDrawn && this.peaks && this.peaks.length > 0) {
                this.drawWaveFromContext();
            }
        },

        seek(event) {
            const rect = this.$refs.waveContainer.getBoundingClientRect();
            const pct = (rect.right - event.clientX) / rect.width;
            const clampedPct = Math.max(0, Math.min(1, pct));
            const trackDuration = parseInt(this.$el.dataset.phpDuration || '0', 10);
            const previewSec = parseInt(this.$el.dataset.previewSec || '0', 10);
            const canPlay = this.$el.dataset.canPlay === 'true';
            const targetTime = clampedPct * (trackDuration || 0);

            if (!canPlay && previewSec > 0 && targetTime >= previewSec) return;

            const store = Alpine.store('player');
            if (!this.isThisTrack) {
                const trackData = safeJsonParse(this.$el.dataset.trackPayload);
                if (trackData) {
                    store.play(trackData);
                    setTimeout(() => {
                        if (store.audio) store.audio.currentTime = targetTime;
                    }, 300);
                }
            } else if (store.audio) {
                store.audio.currentTime = targetTime;
            }
            this.lastCheckedSecond = -1;
        },

        formatTime(s) {
            if (!s || isNaN(s)) return '0:00';
            const m = Math.floor(s / 60);
            const sec = Math.floor(s % 60);
            return m + ':' + String(sec).padStart(2, '0');
        },

        destroy() {
            if (this.animFrame) cancelAnimationFrame(this.animFrame);
        }
    }));
}

function safeJsonParse(str) {
    if (typeof str !== 'string') return null;
    try {
        return JSON.parse(str);
    } catch {
        return null;
    }
}

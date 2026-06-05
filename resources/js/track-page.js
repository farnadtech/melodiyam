import { getCsrfToken } from './security';

let _trackPageRegistered = false;

export function registerTrackPage(Alpine) {
    if (_trackPageRegistered) return;
    _trackPageRegistered = true;

    Alpine.data('trackComments', () => ({
        newBody: '',
        submitting: false,
        replyTo: null,
        newComments: [],
        commentCount: 0,
        trackId: null,
        storeUrl: '',

        init() {
            this.trackId = parseInt(this.$el.dataset.trackId || '0', 10);
            this.commentCount = parseInt(this.$el.dataset.commentCount || '0', 10);
            this.storeUrl = this.$el.dataset.commentUrl || '';
        },

        async submitComment() {
            const body = String(this.newBody || '').trim().slice(0, 2000);
            if (!body || this.submitting || !this.storeUrl || !this.trackId) return;

            this.submitting = true;
            const store = Alpine.store('player');
            let ts = null;
            if (store.currentTrack && store.currentTrack.id === this.trackId && store.audio) {
                ts = Math.floor(store.audio.currentTime);
            }

            const csrf = getCsrfToken();
            if (!csrf) {
                this.submitting = false;
                return;
            }

            try {
                const resp = await fetch(this.storeUrl, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrf,
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        commentable_type: 'track',
                        commentable_id: this.trackId,
                        body: body,
                        timestamp_at: ts,
                    })
                });
                if (!resp.ok) return;
                const data = await resp.json();
                this.newComments.unshift(data);
                this.commentCount++;
                this.newBody = '';
            } catch {
                /* silent */
            }
            this.submitting = false;
        },

        async submitReply(parentId, body) {
            const safeBody = String(body || '').trim().slice(0, 2000);
            if (!safeBody || !this.storeUrl || !this.trackId) return;

            const csrf = getCsrfToken();
            if (!csrf) return;

            try {
                const resp = await fetch(this.storeUrl, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrf,
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        commentable_type: 'track',
                        commentable_id: this.trackId,
                        body: safeBody,
                        parent_id: parentId,
                    })
                });
                if (!resp.ok) return;
                this.replyTo = null;
                this.commentCount++;
            } catch {
                /* silent */
            }
        }
    }));
}

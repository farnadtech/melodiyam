/**
 * Client-side security helpers (OWASP-aligned).
 * Defense-in-depth — server-side validation remains authoritative.
 */

export function escapeHtml(str) {
    if (str == null) return '';
    return String(str)
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;')
        .replace(/'/g, '&#039;');
}

export function isSafeUrl(url) {
    if (!url || typeof url !== 'string') return false;
    if (url.startsWith('/') && !url.startsWith('//')) return true;
    try {
        const parsed = new URL(url, window.location.origin);
        return parsed.origin === window.location.origin
            && ['http:', 'https:'].includes(parsed.protocol);
    } catch {
        return false;
    }
}

export function sanitizeTrack(track) {
    if (!track || typeof track !== 'object') return null;

    const id = track.id;
    if (id === undefined || id === null || id === '') return null;

    const url = typeof track.url === 'string' ? track.url : '';
    if (url && !isSafeUrl(url)) return null;

    const purchaseUrl = track.purchaseUrl ? String(track.purchaseUrl) : '';
    const safePurchase = purchaseUrl && isSafeUrl(purchaseUrl) ? purchaseUrl : '';

    return {
        id: track.id,
        title: String(track.title || '').slice(0, 500),
        artist: String(track.artist || '').slice(0, 200),
        url: url,
        cover: typeof track.cover === 'string' && isSafeUrl(track.cover) ? track.cover : String(track.cover || ''),
        cover_page: track.cover_page && isSafeUrl(track.cover_page) ? track.cover_page : '',
        artist_url: track.artist_url && isSafeUrl(track.artist_url) ? track.artist_url : '',
        duration: Number(track.duration) || 0,
        previewSeconds: Math.max(0, Number(track.previewSeconds) || 0),
        canPlay: Boolean(track.canPlay),
        isPremium: Boolean(track.isPremium),
        price: Number(track.price) || 0,
        discountPrice: track.discountPrice != null ? Number(track.discountPrice) : null,
        purchaseUrl: safePurchase,
    };
}

export function getCsrfToken() {
    const token = document.querySelector('meta[name="csrf-token"]')?.content;
    return token && typeof token === 'string' ? token : '';
}

export function safeJsonParse(str, fallback = null) {
    if (typeof str !== 'string') return fallback;
    try {
        return JSON.parse(str);
    } catch {
        return fallback;
    }
}

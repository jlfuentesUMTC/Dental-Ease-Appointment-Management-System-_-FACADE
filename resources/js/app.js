import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

window.Pusher = Pusher;

const reverbKey = import.meta.env.VITE_REVERB_APP_KEY;

if (reverbKey) {
    window.Echo = new Echo({
        broadcaster: 'reverb',
        key: reverbKey,
        wsHost: import.meta.env.VITE_REVERB_HOST ?? window.location.hostname,
        wsPort: import.meta.env.VITE_REVERB_PORT ?? 8080,
        wssPort: import.meta.env.VITE_REVERB_PORT ?? 8080,
        forceTLS: (import.meta.env.VITE_REVERB_SCHEME ?? 'http') === 'https',
        enabledTransports: ['ws', 'wss'],
    });
}

const currentUserId = window.DentalEaseUser?.id;
let refreshInFlight = false;

if (window.Echo && currentUserId) {
    window.Echo.private(`App.Models.User.${currentUserId}`)
        .listen('.app.notification.created', (event) => {
            incrementNotificationBadges();
            prependNotification(event);
            showNotificationToast(event);
            refreshRealtimeSections(event);
        })
        .listen('.appointment.changed', (event) => {
            refreshRealtimeSections(event);
        });
}

startRealtimeFallbackSync();

function incrementNotificationBadges() {
    document.querySelectorAll('[data-notification-count]').forEach((badge) => {
        const current = Number.parseInt(badge.textContent || '0', 10) || 0;
        badge.textContent = current + 1;
        badge.classList.remove('hidden');
    });
}

function prependNotification(notification) {
    document.querySelectorAll('[data-notification-list]').forEach((list) => {
        list.querySelector('[data-notification-empty]')?.remove();

        const item = document.createElement('a');
        item.href = list.dataset.notificationHref || '#';
        item.className = 'block px-4 py-3 border-b border-slate-50 bg-cyan-50';
        item.innerHTML = `
            <div class="text-[10px] font-black uppercase tracking-widest text-slate-900">${escapeHtml(notification.title)}</div>
            <div class="text-xs text-slate-500 font-semibold mt-1 leading-snug">${escapeHtml(notification.message)}</div>
            <div class="text-[9px] text-slate-300 font-black uppercase tracking-widest mt-2">${escapeHtml(notification.created_at || 'Just now')}</div>
        `;

        list.prepend(item);
    });
}

function showNotificationToast(notification) {
    const toast = document.createElement('div');
    toast.className = 'fixed right-4 top-4 z-[100] max-w-sm rounded-2xl bg-slate-950 px-5 py-4 text-white shadow-2xl';
    toast.innerHTML = `
        <div class="text-[10px] font-black uppercase tracking-widest text-cyan-300">${escapeHtml(notification.title)}</div>
        <div class="mt-1 text-sm font-semibold leading-snug">${escapeHtml(notification.message)}</div>
    `;

    document.body.appendChild(toast);

    window.setTimeout(() => {
        toast.remove();
    }, 5000);
}

async function refreshRealtimeSections(notification) {
    if (!document.querySelector('[data-realtime-section], [data-notification-list]')) {
        return;
    }

    if (refreshInFlight) {
        return;
    }

    refreshInFlight = true;

    try {
        const response = await fetch(window.location.href, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
            },
            credentials: 'same-origin',
        });

        if (!response.ok) {
            return;
        }

        const html = await response.text();
        const nextDocument = new DOMParser().parseFromString(html, 'text/html');

        refreshNotificationElements(nextDocument);

        document.querySelectorAll('[data-realtime-section]').forEach((section) => {
            const name = section.dataset.realtimeSection;
            const nextSection = nextDocument.querySelector(`[data-realtime-section="${CSS.escape(name)}"]`);

            if (nextSection && section.innerHTML.trim() !== nextSection.innerHTML.trim()) {
                section.innerHTML = nextSection.innerHTML;

                if (notification?.source !== 'fallback-sync') {
                    section.classList.add('fade-in-soft');
                    window.setTimeout(() => section.classList.remove('fade-in-soft'), 500);
                }
            }
        });

        window.dispatchEvent(new CustomEvent('dentalease:realtime-sections-refreshed', {
            detail: notification,
        }));
    } catch (error) {
        console.warn('Realtime section refresh failed.', error);
    } finally {
        refreshInFlight = false;
    }
}

function refreshNotificationElements(nextDocument) {
    document.querySelectorAll('[data-notification-count]').forEach((badge, index) => {
        const nextBadge = nextDocument.querySelectorAll('[data-notification-count]')[index];

        if (nextBadge && badge.outerHTML !== nextBadge.outerHTML) {
            badge.textContent = nextBadge.textContent;
            badge.className = nextBadge.className;
        }
    });

    document.querySelectorAll('[data-notification-list]').forEach((list) => {
        const href = list.dataset.notificationHref;
        const selector = href
            ? `[data-notification-list][data-notification-href="${CSS.escape(href)}"]`
            : '[data-notification-list]';
        const nextList = nextDocument.querySelector(selector);

        if (nextList && list.innerHTML.trim() !== nextList.innerHTML.trim()) {
            list.innerHTML = nextList.innerHTML;
        }
    });
}

function startRealtimeFallbackSync() {
    if (!document.querySelector('[data-realtime-section], [data-notification-list]')) {
        return;
    }

    window.setInterval(() => {
        if (document.hidden) {
            return;
        }

        refreshRealtimeSections({ source: 'fallback-sync' });
    }, 2500);
}

function escapeHtml(value) {
    return String(value ?? '')
        .replaceAll('&', '&amp;')
        .replaceAll('<', '&lt;')
        .replaceAll('>', '&gt;')
        .replaceAll('"', '&quot;')
        .replaceAll("'", '&#039;');
}

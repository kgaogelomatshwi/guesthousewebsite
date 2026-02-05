import './bootstrap';

const trackEvent = (type, meta = {}) => {
    const payload = { ...meta, path: window.location.pathname };
    fetch('/analytics/track', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '',
        },
        body: JSON.stringify({ type, meta: payload }),
    }).catch(() => {});

    if (window.gtag) {
        window.gtag('event', type, payload);
    }
};

const attachCtaTracking = () => {
    document.querySelectorAll('.js-track-cta').forEach((el) => {
        el.addEventListener('click', () => {
            const eventType = el.dataset.event || 'cta_click';
            trackEvent(eventType, { href: el.getAttribute('href') });
        });
    });
};

const handleSectionFields = () => {
    const selector = document.getElementById('section-type');
    if (!selector) {
        return;
    }
    const update = () => {
        const type = selector.value;
        document.querySelectorAll('.section-fields').forEach((block) => {
            block.style.display = block.dataset.type === type ? 'block' : 'none';
        });
    };
    selector.addEventListener('change', update);
    update();
};

document.addEventListener('DOMContentLoaded', () => {
    attachCtaTracking();
    handleSectionFields();
    const bodyEvent = document.body?.dataset?.trackEvent;
    if (bodyEvent) {
        trackEvent(bodyEvent);
    }
});

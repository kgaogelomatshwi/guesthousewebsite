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

const attachSortableLists = () => {
    document.querySelectorAll('.js-sortable').forEach((list) => {
        let dragged = null;

        const updatePositions = () => {
            const items = Array.from(list.querySelectorAll('.sortable-item'));
            items.forEach((item, index) => {
                const input = item.querySelector('input[type="hidden"]');
                if (input) {
                    input.value = index + 1;
                }
            });
        };

        list.addEventListener('dragstart', (event) => {
            const target = event.target.closest('.sortable-item');
            if (!target) return;
            dragged = target;
            target.classList.add('is-dragging');
            event.dataTransfer.effectAllowed = 'move';
        });

        list.addEventListener('dragend', () => {
            if (dragged) {
                dragged.classList.remove('is-dragging');
                dragged = null;
            }
            updatePositions();
        });

        list.addEventListener('dragover', (event) => {
            event.preventDefault();
            const target = event.target.closest('.sortable-item');
            if (!target || target === dragged) return;
            const rect = target.getBoundingClientRect();
            const next = (event.clientY - rect.top) / rect.height > 0.5;
            list.insertBefore(dragged, next ? target.nextSibling : target);
        });

        updatePositions();
    });
};

const attachCopyButtons = () => {
    document.querySelectorAll('.js-copy').forEach((btn) => {
        btn.addEventListener('click', async () => {
            const text = btn.dataset.copy || '';
            if (!text) return;
            try {
                await navigator.clipboard.writeText(text);
                btn.textContent = 'Copied';
                setTimeout(() => {
                    btn.textContent = 'Copy URL';
                }, 1500);
            } catch {
                btn.textContent = 'Failed';
                setTimeout(() => {
                    btn.textContent = 'Copy URL';
                }, 1500);
            }
        });
    });
};

const attachMediaPickers = () => {
    document.querySelectorAll('.js-media-picker').forEach((select) => {
        select.addEventListener('change', () => {
            const targetId = select.dataset.target;
            const target = targetId ? document.getElementById(targetId) : null;
            if (target) {
                target.value = select.value || '';
            }
        });
    });

    document.querySelectorAll('.js-media-copy').forEach((select) => {
        select.addEventListener('change', async () => {
            if (!select.value) return;
            try {
                await navigator.clipboard.writeText(select.value);
            } catch {
                // ignore clipboard failures
            }
        });
    });
};

const attachHeroSlider = () => {
    document.querySelectorAll('.hero-slider').forEach((slider) => {
        const slides = Array.from(slider.querySelectorAll('.hero-slide'));
        if (slides.length <= 1) {
            return;
        }
        const interval = Number(slider.dataset.interval || 6000);
        const dots = Array.from(slider.querySelectorAll('[data-hero-dot]'));
        const prevBtn = slider.querySelector('[data-hero-prev]');
        const nextBtn = slider.querySelector('[data-hero-next]');
        let index = 0;
        let timer = null;

        const setActive = (next) => {
            slides.forEach((slide, i) => {
                const isActive = i === next;
                slide.classList.toggle('opacity-100', isActive);
                slide.classList.toggle('opacity-0', !isActive);
                slide.classList.toggle('is-active', isActive);
            });
            dots.forEach((dot, i) => {
                const isActive = i === next;
                dot.classList.toggle('is-active', isActive);
                dot.setAttribute('aria-pressed', isActive ? 'true' : 'false');
            });
            index = next;
        };

        const next = () => setActive((index + 1) % slides.length);
        const prev = () => setActive((index - 1 + slides.length) % slides.length);

        const start = () => {
            if (timer) clearInterval(timer);
            timer = setInterval(() => {
                next();
            }, interval);
        };

        setActive(0);
        start();

        if (prevBtn) {
            prevBtn.addEventListener('click', () => {
                prev();
                start();
            });
        }

        if (nextBtn) {
            nextBtn.addEventListener('click', () => {
                next();
                start();
            });
        }

        dots.forEach((dot) => {
            dot.addEventListener('click', () => {
                const target = Number(dot.dataset.heroDot || 0);
                setActive(target);
                start();
            });
        });

        slider.addEventListener('mouseenter', () => {
            if (timer) clearInterval(timer);
        });

        slider.addEventListener('mouseleave', () => {
            start();
        });

        let touchStartX = 0;
        let touchStartY = 0;
        slider.addEventListener('touchstart', (event) => {
            const touch = event.touches[0];
            if (!touch) return;
            touchStartX = touch.clientX;
            touchStartY = touch.clientY;
        }, { passive: true });

        slider.addEventListener('touchend', (event) => {
            const touch = event.changedTouches[0];
            if (!touch) return;
            const deltaX = touch.clientX - touchStartX;
            const deltaY = touch.clientY - touchStartY;
            if (Math.abs(deltaX) > 50 && Math.abs(deltaX) > Math.abs(deltaY)) {
                if (deltaX > 0) {
                    prev();
                } else {
                    next();
                }
                start();
            }
        });
    });
};

const attachHeroSliderAdmin = () => {
    document.querySelectorAll('.js-add-slide').forEach((button) => {
        button.addEventListener('click', () => {
            const templateId = button.dataset.templateTarget;
            const template = templateId ? document.getElementById(templateId) : null;
            const list = document.getElementById('hero-slider-list');
            if (!template || !list) return;

            const current = list.querySelectorAll('.slider-item').length;
            const index = current;
            const number = index + 1;
            const html = template.innerHTML
                .replaceAll('__INDEX__', String(index))
                .replaceAll('__NUMBER__', String(number));
            const wrapper = document.createElement('div');
            wrapper.innerHTML = html.trim();
            const node = wrapper.firstElementChild;
            if (node) {
                list.appendChild(node);
                attachMediaPickers();
                attachHeroSliderRemove();
            }
        });
    });
};

const attachHeroSliderRemove = () => {
    document.querySelectorAll('.js-remove-slide').forEach((button) => {
        if (button.dataset.bound === '1') {
            return;
        }
        button.dataset.bound = '1';
        button.addEventListener('click', () => {
            const item = button.closest('.slider-item');
            if (item) {
                item.remove();
            }
        });
    });
};

const attachMobileNav = () => {
    const toggle = document.querySelector('.nav-toggle');
    const nav = document.getElementById('site-nav');
    if (!toggle || !nav) return;
    toggle.addEventListener('click', () => {
        const isOpen = nav.classList.toggle('max-h-80');
        nav.classList.toggle('py-3', isOpen);
        toggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
    });
};

document.addEventListener('DOMContentLoaded', () => {
    attachCtaTracking();
    handleSectionFields();
    attachSortableLists();
    attachCopyButtons();
    attachMediaPickers();
    attachHeroSlider();
    attachHeroSliderAdmin();
    attachHeroSliderRemove();
    attachMobileNav();
    const bodyEvent = document.body?.dataset?.trackEvent;
    if (bodyEvent) {
        trackEvent(bodyEvent);
    }
});

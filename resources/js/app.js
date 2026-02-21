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

    const toggleBlockControls = (block, enabled) => {
        block.querySelectorAll('input, select, textarea, button').forEach((field) => {
            field.disabled = !enabled;
        });
    };

    const update = () => {
        const type = selector.value;
        document.querySelectorAll('.section-fields').forEach((block) => {
            const isActive = block.dataset.type === type;
            block.style.display = isActive ? 'block' : 'none';
            block.setAttribute('aria-hidden', isActive ? 'false' : 'true');
            toggleBlockControls(block, isActive);
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

const attachMediaModal = () => {
    const modal = document.getElementById('media-picker-modal');
    if (!modal) return;

    const grid = modal.querySelector('#media-picker-grid');
    const searchInput = modal.querySelector('#media-picker-search');
    const filterButtons = Array.from(modal.querySelectorAll('[data-media-filter]'));
    const closeButtons = Array.from(modal.querySelectorAll('[data-media-close]'));
    const insertModeInputs = Array.from(modal.querySelectorAll('input[name="media-insert-mode"]'));
    let currentTarget = null;
    let currentFilter = 'all';
    let mediaItems = [];

    const openModal = (target, filter) => {
        currentTarget = target;
        currentFilter = filter || 'all';
        modal.classList.remove('hidden');
        filterButtons.forEach((btn) => {
            const active = btn.dataset.mediaFilter === currentFilter;
            btn.classList.toggle('btn-primary', active);
            btn.classList.toggle('btn-outline', !active);
        });
        loadMedia();
    };

    const closeModal = () => {
        modal.classList.add('hidden');
        currentTarget = null;
        if (searchInput) searchInput.value = '';
    };

    const getInsertMode = () => {
        const checked = insertModeInputs.find((input) => input.checked);
        return checked ? checked.value : 'path';
    };

    const matchesFilter = (item) => {
        if (currentFilter === 'all') return true;
        if (currentFilter === 'pdf') return item.mime_type === 'application/pdf';
        return item.mime_type?.startsWith(currentFilter + '/');
    };

    const matchesSearch = (item) => {
        const term = (searchInput?.value || '').toLowerCase();
        if (!term) return true;
        return [item.title, item.path, item.mime_type].some((value) => (value || '').toLowerCase().includes(term));
    };

    const renderGrid = () => {
        if (!grid) return;
        const items = mediaItems.filter((item) => matchesFilter(item) && matchesSearch(item));
        grid.innerHTML = items
            .map((item) => {
                const url = item.url;
                const mime = item.mime_type || '';
                let preview = `<div class="p-4 bg-neutral-100 rounded-lg text-sm">File</div>`;
                if (mime.startsWith('image/')) {
                    preview = `<img src="${url}" alt="${item.title || ''}" class="h-36 w-full object-cover rounded-lg">`;
                } else if (mime.startsWith('video/')) {
                    preview = `<video class="h-36 w-full object-cover rounded-lg" src="${url}" controls></video>`;
                } else if (mime.startsWith('audio/')) {
                    preview = `<audio class="w-full" src="${url}" controls></audio>`;
                } else if (mime === 'application/pdf') {
                    preview = `<div class="p-4 bg-neutral-100 rounded-lg text-sm">PDF</div>`;
                }
                return `
                    <div class="media-card">
                        ${preview}
                        <div>
                            <strong>${item.title || 'Media'}</strong>
                            <p><small>${mime || 'unknown'}</small></p>
                        </div>
                        <button class="btn btn-primary js-media-choose" data-path="${item.path}" data-url="${url}" type="button">Use</button>
                    </div>
                `;
            })
            .join('');
    };

    const loadMedia = async () => {
        try {
            const params = new URLSearchParams();
            if (currentFilter && currentFilter !== 'all') {
                params.set('type', currentFilter);
            }
            if (searchInput?.value) {
                params.set('q', searchInput.value);
            }
            const res = await fetch(`/admin/media-picker?${params.toString()}`);
            mediaItems = res.ok ? await res.json() : [];
            renderGrid();
        } catch {
            mediaItems = [];
            renderGrid();
        }
    };

    document.querySelectorAll('.js-media-open').forEach((btn) => {
        btn.addEventListener('click', () => {
            const targetId = btn.dataset.mediaTarget;
            if (!targetId) return;
            const target = document.getElementById(targetId);
            if (!target) return;
            openModal(target, btn.dataset.mediaType || 'all');
        });
    });

    modal.addEventListener('click', (event) => {
        const chooseBtn = event.target.closest('.js-media-choose');
        if (!chooseBtn || !currentTarget) return;
        const value = getInsertMode() === 'url' ? chooseBtn.dataset.url : chooseBtn.dataset.path;
        if (!value) return;

        if (currentTarget.tagName === 'SELECT') {
            let option = Array.from(currentTarget.options).find((opt) => opt.value === value);
            if (!option) {
                option = new Option(value, value, true, true);
                currentTarget.add(option);
            }
            option.selected = true;
        } else {
            currentTarget.value = value;
            currentTarget.dispatchEvent(new Event('input', { bubbles: true }));
        }
        closeModal();
    });

    if (searchInput) {
        searchInput.addEventListener('input', () => {
            renderGrid();
        });
    }

    filterButtons.forEach((btn) => {
        btn.addEventListener('click', () => {
            currentFilter = btn.dataset.mediaFilter || 'all';
            filterButtons.forEach((b) => {
                const active = b.dataset.mediaFilter === currentFilter;
                b.classList.toggle('btn-primary', active);
                b.classList.toggle('btn-outline', !active);
            });
            loadMedia();
        });
    });

    closeButtons.forEach((btn) => {
        btn.addEventListener('click', closeModal);
    });

    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape' && !modal.classList.contains('hidden')) {
            closeModal();
        }
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
                attachMediaModal();
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
        const isOpen = nav.classList.toggle('is-open');
        toggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
    });
};

document.addEventListener('DOMContentLoaded', () => {
    attachCtaTracking();
    handleSectionFields();
    attachSortableLists();
    attachCopyButtons();
    attachMediaPickers();
    attachMediaModal();
    attachHeroSlider();
    attachHeroSliderAdmin();
    attachHeroSliderRemove();
    attachMobileNav();
    const bodyEvent = document.body?.dataset?.trackEvent;
    if (bodyEvent) {
        trackEvent(bodyEvent);
    }
});

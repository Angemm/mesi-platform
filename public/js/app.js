/* ════════════════════════════════════
   M.E.SI — app.js  (public/js/app.js)
   ════════════════════════════════════ */

document.addEventListener('DOMContentLoaded', () => {

    /* ── Navbar scroll ── */
    const navbar = document.getElementById('navbar');
    const onScroll = () => navbar?.classList.toggle('shadow-xl', window.scrollY > 60);
    window.addEventListener('scroll', onScroll, { passive: true });

    /* ── Mobile menu ── */
    const toggle   = document.getElementById('navToggle');
    const menu     = document.getElementById('mobileMenu');
    const overlay  = document.getElementById('mobileOverlay');
    const drawer   = document.getElementById('mobileDrawer');
    const closeBtn = document.getElementById('mobileClose');

    const openMenu = () => {
        menu.classList.remove('pointer-events-none');
        overlay.classList.remove('opacity-0');
        drawer.classList.remove('translate-x-full');
        document.body.style.overflow = 'hidden';
        // Burger → X
        const spans = toggle?.querySelectorAll('span');
        if (spans) {
            spans[0].style.cssText = 'transform:rotate(45deg) translate(5px,5px)';
            spans[1].style.cssText = 'opacity:0';
            spans[2].style.cssText = 'transform:rotate(-45deg) translate(5px,-5px)';
        }
    };
    const closeMenu = () => {
        overlay.classList.add('opacity-0');
        drawer.classList.add('translate-x-full');
        document.body.style.overflow = '';
        setTimeout(() => menu.classList.add('pointer-events-none'), 350);
        const spans = toggle?.querySelectorAll('span');
        if (spans) spans.forEach(s => s.style.cssText = '');
    };

    toggle?.addEventListener('click', openMenu);
    closeBtn?.addEventListener('click', closeMenu);
    overlay?.addEventListener('click', closeMenu);

    /* ── Compteurs animés ── */
    const counters = document.querySelectorAll('[data-count]');
    const countObs = new IntersectionObserver((entries, obs) => {
        entries.forEach(entry => {
            if (!entry.isIntersecting) return;
            const el = entry.target;
            const target = parseInt(el.dataset.count);
            const suffix = el.dataset.suffix || '';
            let cur = 0;
            const step = Math.ceil(target / 60);
            const t = setInterval(() => {
                cur = Math.min(cur + step, target);
                el.textContent = cur.toLocaleString('fr-FR') + suffix;
                if (cur >= target) clearInterval(t);
            }, 20);
            obs.unobserve(el);
        });
    }, { threshold: 0.5 });
    counters.forEach(c => countObs.observe(c));

    /* ── Scroll reveal ── */
    const reveals = document.querySelectorAll('.reveal');
    const revealObs = new IntersectionObserver((entries) => {
        entries.forEach(e => {
            if (e.isIntersecting) { e.target.classList.add('visible'); revealObs.unobserve(e.target); }
        });
    }, { threshold: 0.12 });
    reveals.forEach(r => revealObs.observe(r));

    /* ── Progress bars animées ── */
    const bars = document.querySelectorAll('.progress-bar[data-width]');
    const barObs = new IntersectionObserver((entries, obs) => {
        entries.forEach(e => {
            if (e.isIntersecting) {
                e.target.style.width = e.target.dataset.width + '%';
                obs.unobserve(e.target);
            }
        });
    }, { threshold: 0.3 });
    bars.forEach(b => { b.style.width = '0'; barObs.observe(b); });

    /* ── Lecture vidéo overlay ── */
    document.querySelectorAll('.video-overlay').forEach(overlay => {
        overlay.addEventListener('click', () => {
            const iframe = overlay.closest('.video-wrapper')?.querySelector('iframe');
            if (iframe) {
                iframe.src += (iframe.src.includes('?') ? '&' : '?') + 'autoplay=1';
            }
            overlay.style.display = 'none';
        });
    });

    /* ── Auto-dismiss alerts ── */
    setTimeout(() => {
        document.querySelectorAll('#alertSuccess,#alertError').forEach(el => {
            el.style.transition = 'opacity .4s, transform .4s';
            el.style.opacity = '0';
            el.style.transform = 'translateX(20px)';
            setTimeout(() => el.remove(), 400);
        });
    }, 4500);

    /* ── Confirm delete ── */
    document.querySelectorAll('[data-confirm]').forEach(btn => {
        btn.addEventListener('click', e => {
            if (!confirm(btn.dataset.confirm || 'Confirmer cette action ?')) e.preventDefault();
        });
    });

    /* ── Image preview on file input ── */
    document.querySelectorAll('input[type="file"][data-preview]').forEach(input => {
        const prev = document.getElementById(input.dataset.preview);
        if (!prev) return;
        input.addEventListener('change', () => {
            const file = input.files[0];
            if (file && prev.tagName === 'IMG') {
                prev.src = URL.createObjectURL(file);
                prev.classList.remove('hidden');
            }
        });
    });

    /* ── Tabs ── */
    document.querySelectorAll('[data-tab-group]').forEach(group => {
        const groupId = group.dataset.tabGroup;
        const btns = group.querySelectorAll('[data-tab]');
        const panels = document.querySelectorAll(`[data-tab-panel="${groupId}"]`);
        btns.forEach(btn => {
            btn.addEventListener('click', () => {
                btns.forEach(b => b.classList.remove('tab-active'));
                btn.classList.add('tab-active');
                panels.forEach(p => p.classList.toggle('hidden', p.dataset.panel !== btn.dataset.tab));
            });
        });
    });

    /* ── Admin sidebar mobile ── */
    const adminToggle = document.getElementById('adminSidebarToggle');
    const adminSidebar = document.getElementById('adminSidebar');
    adminToggle?.addEventListener('click', () => adminSidebar?.classList.toggle('-translate-x-full'));

    /* ── Carousel leaders ── */
    initCarousel();
});

/* ══ Carousel fonction globale ══ */
function initCarousel() {
    const carousel = document.getElementById('leaderCarousel');
    if (!carousel) return;

    const items = carousel.querySelectorAll('[data-carousel-item]');
    const dots  = document.getElementById('carouselDots');
    let cur = 0;
    let timer;

    const go = (n) => {
        items[cur].classList.add('opacity-0', 'translate-y-2');
        items[cur].classList.remove('opacity-100', 'translate-y-0');
        cur = (n + items.length) % items.length;
        items[cur].classList.remove('opacity-0', 'translate-y-2');
        items[cur].classList.add('opacity-100', 'translate-y-0');
        updateDots();
    };

    const updateDots = () => {
        if (!dots) return;
        dots.querySelectorAll('button').forEach((d, i) => {
            d.className = i === cur
                ? 'w-8 h-2.5 rounded-full bg-gold transition-all duration-300'
                : 'w-2.5 h-2.5 rounded-full bg-slate-200 hover:bg-gold/50 transition-all duration-300';
        });
    };

    // Init items visibility
    items.forEach((item, i) => {
        item.classList.add('transition-all', 'duration-500', 'absolute', 'inset-0');
        if (i === 0) item.classList.add('opacity-100', 'translate-y-0');
        else item.classList.add('opacity-0', 'translate-y-2');
    });
    carousel.style.position = 'relative';

    // Build dots
    if (dots) {
        items.forEach((_, i) => {
            const btn = document.createElement('button');
            btn.onclick = () => { clearInterval(timer); go(i); };
            dots.appendChild(btn);
        });
        updateDots();
    }

    // Nav buttons
    document.getElementById('carouselPrev')?.addEventListener('click', () => { clearInterval(timer); go(cur - 1); });
    document.getElementById('carouselNext')?.addEventListener('click', () => { clearInterval(timer); go(cur + 1); });

    timer = setInterval(() => go(cur + 1), 7000);
}

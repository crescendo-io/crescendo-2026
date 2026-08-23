(function () {
    function initMockupsCarousel() {
        var root = document.querySelector('.landing-mockups');
        var viewport = root ? root.querySelector('.landing-mockups__viewport') : null;
        var track = root ? root.querySelector('.landing-mockups__track') : null;

        if (!root || !viewport || !track) {
            return;
        }

        var visible = window.matchMedia('(max-width: 767px)').matches ? 2 : 4;
        var trackStyles = window.getComputedStyle(track);
        var gap = parseFloat(trackStyles.columnGap || trackStyles.gap) || 16;
        var viewportWidth = viewport.clientWidth;
        var itemWidth = Math.max(160, (viewportWidth - gap * (visible - 1)) / visible);

        root.style.setProperty('--mockup-item-width', itemWidth + 'px');

        var firstSet = track.querySelectorAll('.landing-mockups__item:not([aria-hidden="true"])');
        var shift = 0;

        firstSet.forEach(function (item, index) {
            shift += item.getBoundingClientRect().width;
            if (index < firstSet.length - 1) {
                shift += gap;
            }
        });

        if (shift > 0) {
            track.style.setProperty('--mockup-shift', shift + 'px');
        }

        var duration = track.style.getPropertyValue('--mockup-duration').trim();
        if (!duration) {
            var count = parseInt(track.style.getPropertyValue('--mockup-count'), 10) || 6;
            duration = Math.max(20, count * 5) + 's';
            track.style.setProperty('--mockup-duration', duration);
        }

        if (!window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
            track.style.animation = 'none';
            void track.offsetWidth;
            track.style.animation = 'landing-mockups-scroll ' + duration + ' linear infinite';
        }
    }

    function initTestimonialsCarousel() {
        var root = document.querySelector('.landing-testimonials');
        var viewport = root ? root.querySelector('.landing-testimonials__viewport') : null;
        var track = root ? root.querySelector('.landing-testimonials__track') : null;

        if (!root || !viewport || !track) {
            return;
        }

        var visible = 3;
        if (window.matchMedia('(max-width: 767px)').matches) {
            visible = 1;
        } else if (window.matchMedia('(max-width: 1099px)').matches) {
            visible = 2;
        }

        var trackStyles = window.getComputedStyle(track);
        var gap = parseFloat(trackStyles.columnGap || trackStyles.gap) || 32;
        var viewportWidth = viewport.clientWidth;
        var itemWidth = Math.max(240, (viewportWidth - gap * (visible - 1)) / visible);

        root.style.setProperty('--testimonial-gap', gap + 'px');
        root.style.setProperty('--testimonial-item-width', itemWidth + 'px');

        var firstSet = track.querySelectorAll('.landing-testimonial:not([aria-hidden="true"])');
        var shift = 0;

        firstSet.forEach(function (item, index) {
            shift += item.getBoundingClientRect().width;
            if (index < firstSet.length - 1) {
                shift += gap;
            }
        });

        if (shift > 0) {
            track.style.setProperty('--testimonial-shift', shift + 'px');
        }

        var duration = track.style.getPropertyValue('--testimonial-duration').trim();
        if (!duration) {
            var count = parseInt(track.style.getPropertyValue('--testimonial-count'), 10) || 6;
            duration = Math.max(36, count * 8) + 's';
            track.style.setProperty('--testimonial-duration', duration);
        }

        if (!window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
            track.style.animation = 'none';
            void track.offsetWidth;
            track.style.animation = 'landing-testimonials-scroll ' + duration + ' linear infinite';
        }
    }

    var resizeTimer;
    function scheduleCarouselUpdate() {
        window.clearTimeout(resizeTimer);
        resizeTimer = window.setTimeout(function () {
            initMockupsCarousel();
            initTestimonialsCarousel();
        }, 120);
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', function () {
            initMockupsCarousel();
            initTestimonialsCarousel();
        });
    } else {
        initMockupsCarousel();
        initTestimonialsCarousel();
    }

    window.addEventListener('load', function () {
        initMockupsCarousel();
        initTestimonialsCarousel();
    });
    window.addEventListener('resize', scheduleCarouselUpdate);

    var sticky = document.querySelector('.landing-sticky-cta');
    if (!sticky) {
        return;
    }

    var contact = document.getElementById('contact-bas');
    var heroZone = document.querySelector('.landing-mockups') || document.querySelector('.landing-hero');

    function updateSticky() {
        var scrollY = window.scrollY || window.pageYOffset;
        var heroBottom = heroZone ? heroZone.offsetTop + heroZone.offsetHeight : 400;
        var contactTop = contact ? contact.offsetTop - window.innerHeight * 0.5 : Infinity;
        var show = scrollY > heroBottom && scrollY < contactTop;

        sticky.hidden = !show;
    }

    window.addEventListener('scroll', updateSticky, { passive: true });
    window.addEventListener('resize', updateSticky);
    updateSticky();
}());

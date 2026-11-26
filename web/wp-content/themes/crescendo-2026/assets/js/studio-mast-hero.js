(function () {
    function initStudioMastHero() {
        var mast = document.querySelector('.studio-mast');
        var hero = document.querySelector('.studio-hero--immersive');
        var sentinel = document.getElementById('projets');

        if (!mast || !hero || !document.body.classList.contains('has-immersive-hero')) {
            return;
        }

        var reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
        var headerLine = 92;
        var heroMedia = hero.querySelector('.studio-hero__media');
        var heroGlows = hero.querySelector('.studio-hero__glows');
        var ticking = false;

        function heroScrollProgress() {
            var rect = hero.getBoundingClientRect();
            var heroHeight = Math.max(hero.offsetHeight, 1);
            var scrolled = Math.max(0, -rect.top);
            var range = heroHeight * 0.92;
            return Math.min(scrolled / range, 1);
        }

        function updateMastTheme() {
            var pastHero = sentinel
                ? sentinel.getBoundingClientRect().top <= headerLine
                : hero.getBoundingClientRect().bottom <= headerLine;

            document.body.classList.toggle('studio-hero-scrolled', pastHero);
            mast.classList.toggle('is-past-hero', pastHero);
        }

        function updateHeroScrollFx() {
            if (reducedMotion) {
                return;
            }

            var progress = heroScrollProgress();
            var eased = 1 - Math.pow(1 - progress, 1.35);

            if (heroMedia) {
                var opacity = 0.15 - eased * 0.09;
                heroMedia.style.opacity = String(Math.max(opacity, 0.04));
            }

            if (heroGlows) {
                var scale = 1 + eased * 0.14;
                var shiftX = eased * 3.2;
                var shiftY = eased * -2.4;
                var lift = eased * 0.22;
                heroGlows.style.setProperty('--studio-hero-glow-scale', scale.toFixed(4));
                heroGlows.style.setProperty('--studio-hero-glow-shift-x', shiftX.toFixed(2) + 'vw');
                heroGlows.style.setProperty('--studio-hero-glow-shift-y', shiftY.toFixed(2) + 'vh');
                heroGlows.style.setProperty('--studio-hero-glow-lift', lift.toFixed(4));
            }
        }

        function onScroll() {
            if (ticking) {
                return;
            }
            ticking = true;
            window.requestAnimationFrame(function () {
                updateMastTheme();
                updateHeroScrollFx();
                ticking = false;
            });
        }

        updateMastTheme();
        updateHeroScrollFx();
        window.addEventListener('scroll', onScroll, { passive: true });
        window.addEventListener('resize', onScroll);
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initStudioMastHero);
    } else {
        initStudioMastHero();
    }
})();
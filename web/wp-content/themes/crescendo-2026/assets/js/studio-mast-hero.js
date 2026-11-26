(function () {
    function getDarkHeroRegion() {
        var secteurHeader = document.querySelector('header.studio-secteur-hero');
        if (secteurHeader) {
            return secteurHeader;
        }

        return (
            document.querySelector('.studio-page-hero__dark-band') ||
            document.querySelector('section.studio-page-hero--dark') ||
            document.querySelector('.studio-services-hub-hero') ||
            document.querySelector('.studio-secteurs-hub-hero') ||
            document.querySelector('.studio-realisations-hero') ||
            document.querySelector('.studio-project-hero.studio-page-hero--dark')
        );
    }

    function initStudioMastHero() {
        var mast = document.querySelector('.studio-mast');
        var immersiveHero = document.querySelector('.studio-hero--immersive');
        var darkHero = getDarkHeroRegion();
        var hero = immersiveHero || darkHero;
        var hasImmersive = document.body.classList.contains('has-immersive-hero');
        var hasDarkPageHero = document.body.classList.contains('has-studio-dark-hero');

        if (!mast || !hero || (!hasImmersive && !hasDarkPageHero)) {
            return;
        }

        var reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
        var headerLine = 92;
        var sentinel = document.getElementById('projets') || document.getElementById('inclus');
        var heroMedia = immersiveHero ? immersiveHero.querySelector('.studio-hero__media') : null;
        var heroGlows = immersiveHero ? immersiveHero.querySelector('.studio-hero__glows') : null;
        var ticking = false;

        function heroScrollProgress() {
            if (!immersiveHero) {
                return 0;
            }

            var rect = immersiveHero.getBoundingClientRect();
            var heroHeight = Math.max(immersiveHero.offsetHeight, 1);
            var scrolled = Math.max(0, -rect.top);
            var range = heroHeight * 0.92;
            return Math.min(scrolled / range, 1);
        }

        function updateMastTheme() {
            var pastHero;

            if (immersiveHero && sentinel) {
                pastHero = sentinel.getBoundingClientRect().top <= headerLine;
            } else {
                pastHero = hero.getBoundingClientRect().bottom <= headerLine;
            }

            document.body.classList.toggle('studio-hero-scrolled', pastHero);
            mast.classList.toggle('is-past-hero', pastHero);
        }

        function updateHeroScrollFx() {
            if (reducedMotion || !immersiveHero) {
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
(function () {
    var visibleRatio = 0.35;

    function revealBlock(block) {
        if (block.classList.contains('is-revealed')) {
            return;
        }
        block.classList.add('is-revealed');
    }

    function blockVisibleRatio(element) {
        var rect = element.getBoundingClientRect();
        var viewport = window.innerHeight || document.documentElement.clientHeight || 1;
        var visibleTop = Math.max(rect.top, 0);
        var visibleBottom = Math.min(rect.bottom, viewport);
        var visibleHeight = visibleBottom - visibleTop;

        if (visibleHeight <= 0 || rect.height <= 0) {
            return 0;
        }

        return visibleHeight / rect.height;
    }

    function isBlockVisible(element) {
        return blockVisibleRatio(element) >= visibleRatio;
    }

    function bindScrollReveal(block) {
        if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
            revealBlock(block);
            return;
        }

        function check() {
            if (isBlockVisible(block)) {
                revealBlock(block);
            }
        }

        if (isBlockVisible(block)) {
            revealBlock(block);
            return;
        }

        if (!('IntersectionObserver' in window)) {
            window.addEventListener('scroll', check, { passive: true });
            window.addEventListener('resize', check);
            check();
            return;
        }

        var observer = new IntersectionObserver(
            function (entries) {
                entries.forEach(function (entry) {
                    if (entry.isIntersecting || isBlockVisible(entry.target)) {
                        revealBlock(entry.target);
                        observer.unobserve(entry.target);
                    }
                });
            },
            {
                root: null,
                rootMargin: '0px 0px -8% 0px',
                threshold: [0, 0.15, 0.35, 0.5, 0.75, 1],
            }
        );

        observer.observe(block);

        window.addEventListener(
            'scroll',
            function onScroll() {
                if (!isBlockVisible(block)) {
                    return;
                }
                revealBlock(block);
                observer.unobserve(block);
                window.removeEventListener('scroll', onScroll);
            },
            { passive: true }
        );
    }

    function initStudioCoverReveal() {
        var blocks = document.querySelectorAll('[data-studio-reveal], [data-studio-text-reveal]');
        blocks.forEach(bindScrollReveal);
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initStudioCoverReveal);
    } else {
        initStudioCoverReveal();
    }
})();
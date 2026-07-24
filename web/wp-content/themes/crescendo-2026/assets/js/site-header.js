(function () {
    function initSiteHeader() {
        var navToggle = document.querySelector('[data-nav-toggle]');
        var nav = document.getElementById('site-nav');

        if (!navToggle || !nav) {
            return;
        }

        navToggle.addEventListener('click', function () {
            var isOpen = nav.classList.toggle('is-open');
            navToggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
        });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initSiteHeader);
    } else {
        initSiteHeader();
    }
}());

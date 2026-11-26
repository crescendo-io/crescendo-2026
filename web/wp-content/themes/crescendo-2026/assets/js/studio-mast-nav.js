(function () {
    function closeAllSubmenus(nav) {
        if (!nav) {
            return;
        }
        nav.querySelectorAll('.studio-mast-nav__item--has-children.is-submenu-open').forEach(function (item) {
            item.classList.remove('is-submenu-open');
            var btn = item.querySelector('.studio-mast-nav__subtoggle');
            if (btn) {
                btn.setAttribute('aria-expanded', 'false');
            }
        });
    }

    function setMobileNavOpen(isOpen) {
        var panel = document.querySelector('[data-studio-nav-panel]');
        var toggle = document.querySelector('[data-studio-nav-toggle]');
        var backdrop = document.querySelector('[data-studio-nav-backdrop]');

        if (!panel || !toggle) {
            return;
        }

        panel.classList.toggle('is-open', isOpen);
        toggle.classList.toggle('is-active', isOpen);
        toggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
        document.body.classList.toggle('studio-mast-nav-open', isOpen);

        if (backdrop) {
            backdrop.hidden = !isOpen;
        }

        if (!isOpen) {
            closeAllSubmenus(panel);
        }
    }

    function isDesktopNav() {
        return window.matchMedia('(min-width: 1025px)').matches;
    }

    document.addEventListener('DOMContentLoaded', function () {
        var toggle = document.querySelector('[data-studio-nav-toggle]');
        var panel = document.querySelector('[data-studio-nav-panel]');
        var backdrop = document.querySelector('[data-studio-nav-backdrop]');

        if (!toggle || !panel) {
            return;
        }

        toggle.addEventListener('click', function () {
            var willOpen = !panel.classList.contains('is-open');
            setMobileNavOpen(willOpen);
        });

        if (backdrop) {
            backdrop.addEventListener('click', function () {
                setMobileNavOpen(false);
            });
        }

        panel.addEventListener('click', function (event) {
            var subtoggle = event.target.closest('.studio-mast-nav__subtoggle');
            if (!subtoggle) {
                return;
            }

            var item = subtoggle.closest('.studio-mast-nav__item--has-children');
            if (!item) {
                return;
            }

            event.preventDefault();

            var isOpen = item.classList.contains('is-submenu-open');

            if (!isDesktopNav()) {
                panel.querySelectorAll('.studio-mast-nav__item--has-children.is-submenu-open').forEach(function (openItem) {
                    if (openItem !== item) {
                        openItem.classList.remove('is-submenu-open');
                        var otherBtn = openItem.querySelector('.studio-mast-nav__subtoggle');
                        if (otherBtn) {
                            otherBtn.setAttribute('aria-expanded', 'false');
                        }
                    }
                });
            }

            item.classList.toggle('is-submenu-open', !isOpen);
            subtoggle.setAttribute('aria-expanded', !isOpen ? 'true' : 'false');
        });

        document.addEventListener('keydown', function (event) {
            if (event.key === 'Escape') {
                setMobileNavOpen(false);
            }
        });

        window.addEventListener('resize', function () {
            if (isDesktopNav()) {
                setMobileNavOpen(false);
            }
        });

        panel.querySelectorAll('.studio-mast-nav__subrow-link, .studio-mast-nav__submenu-all').forEach(function (link) {
            link.addEventListener('click', function () {
                if (!isDesktopNav()) {
                    setMobileNavOpen(false);
                }
            });
        });

        panel.querySelectorAll('.studio-mast-nav__item--has-children').forEach(function (item) {
            var closeTimer;

            item.addEventListener('mouseenter', function () {
                if (!isDesktopNav()) {
                    return;
                }
                window.clearTimeout(closeTimer);
                item.classList.add('is-submenu-open');
                var btn = item.querySelector('.studio-mast-nav__subtoggle');
                if (btn) {
                    btn.setAttribute('aria-expanded', 'true');
                }
            });

            item.addEventListener('mouseleave', function () {
                if (!isDesktopNav()) {
                    return;
                }
                closeTimer = window.setTimeout(function () {
                    item.classList.remove('is-submenu-open');
                    var btn = item.querySelector('.studio-mast-nav__subtoggle');
                    if (btn) {
                        btn.setAttribute('aria-expanded', 'false');
                    }
                }, 160);
            });
        });
    });
})();
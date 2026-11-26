export default () => {
    const navToggle = document.querySelector('[data-nav-toggle]');
    const nav = document.getElementById('site-nav');

    if (!navToggle || !nav) {
        return;
    }

    navToggle.addEventListener('click', () => {
        const isOpen = nav.classList.toggle('is-open');
        navToggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
    });

    nav.querySelectorAll('.site-nav__item--has-children > a').forEach((parentLink) => {
        parentLink.addEventListener('click', (event) => {
            if (window.matchMedia('(min-width: 992px)').matches) {
                return;
            }

            const item = parentLink.closest('.site-nav__item--has-children');
            if (!item) {
                return;
            }

            const submenu = item.querySelector('.site-nav__submenu');
            if (!submenu) {
                return;
            }

            event.preventDefault();
            item.classList.toggle('is-submenu-open');
        });
    });
};

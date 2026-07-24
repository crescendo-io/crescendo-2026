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
};

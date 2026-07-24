(function () {
    function markLoaded(loader) {
        if (!loader || loader.classList.contains('is-loaded')) {
            return;
        }
        loader.classList.add('is-loaded');
    }

    function bindLoader(loader) {
        var img = loader.querySelector('img');
        if (!img) {
            markLoaded(loader);
            return;
        }

        if (img.complete && img.naturalWidth > 0) {
            markLoaded(loader);
            return;
        }

        img.addEventListener('load', function () {
            markLoaded(loader);
        }, { once: true });

        img.addEventListener('error', function () {
            markLoaded(loader);
        }, { once: true });
    }

    function initMediaLoaders(root) {
        var scope = root && root.querySelectorAll ? root : document;
        var loaders = scope.querySelectorAll
            ? scope.querySelectorAll('[data-media-loader]:not(.is-loaded)')
            : [];

        Array.prototype.forEach.call(loaders, bindLoader);
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', function () {
            initMediaLoaders(document);
        });
    } else {
        initMediaLoaders(document);
    }

    window.crescendoInitMediaLoaders = initMediaLoaders;
})();

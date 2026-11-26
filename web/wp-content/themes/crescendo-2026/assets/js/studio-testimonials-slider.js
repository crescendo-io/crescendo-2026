(function () {
    function initStudioTestimonialsSlider() {
        var root = document.querySelector('[data-studio-testimonials-slider]');
        if (!root) {
            return;
        }

        var slides = Array.prototype.slice.call(
            root.querySelectorAll('.studio-testimonials-slider__slide')
        );
        if (!slides.length) {
            return;
        }

        var total = slides.length;
        var current = 0;
        var currentEl = root.querySelector('[data-slider-current]');
        var prevBtn = root.querySelector('[data-slider-prev]');
        var nextBtn = root.querySelector('[data-slider-next]');
        var dots = Array.prototype.slice.call(root.querySelectorAll('[data-slider-dot]'));

        function showSlide(index) {
            if (index < 0) {
                index = total - 1;
            }
            if (index >= total) {
                index = 0;
            }
            current = index;

            slides.forEach(function (slide, i) {
                var active = i === current;
                slide.hidden = !active;
                slide.setAttribute('aria-hidden', active ? 'false' : 'true');
            });

            dots.forEach(function (dot, i) {
                var active = i === current;
                dot.classList.toggle('is-active', active);
                dot.setAttribute('aria-selected', active ? 'true' : 'false');
            });

            if (currentEl) {
                currentEl.textContent = String(current + 1);
            }
        }

        if (total <= 1) {
            return;
        }

        if (prevBtn) {
            prevBtn.addEventListener('click', function () {
                showSlide(current - 1);
            });
        }

        if (nextBtn) {
            nextBtn.addEventListener('click', function () {
                showSlide(current + 1);
            });
        }

        dots.forEach(function (dot) {
            dot.addEventListener('click', function () {
                var idx = parseInt(dot.getAttribute('data-slider-dot'), 10);
                if (!isNaN(idx)) {
                    showSlide(idx);
                }
            });
        });

        showSlide(0);
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initStudioTestimonialsSlider);
    } else {
        initStudioTestimonialsSlider();
    }
})();
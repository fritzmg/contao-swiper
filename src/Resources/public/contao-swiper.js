(function() {
    // check if a sliderConfig was created inside the templates
    if (typeof sliderConfig !== 'undefined') {
        var sliders = Object.keys(sliderConfig);
        sliders.forEach(function (sliderId) {
            // get properties for this slider
            var cssClass = sliderConfig[sliderId]['cssclass'];
            var params = sliderConfig[sliderId]['params'];

            // adjust html structure
            var slider = document.getElementById(sliderId);
            var sliderElement = slider.querySelector('.swiper-container');
            sliderElement.innerHTML = '<div class="swiper-wrapper">' + sliderElement.innerHTML + '</div>'; // add the swiper-wrapper element inside the swiper-container
            var wrapperElement = sliderElement.querySelector('.swiper-wrapper');
            if (cssClass) {
                // add custom css class
                wrapperElement.classList.add(cssClass);
            }
            // get all Elements inside the wrapper
            var slides = wrapperElement.children;
            for (var j = 0; j < slides.length; j++) {
                slides[j].classList.add('swiper-slide');
            }

            // adding pagination
            if (params.pagination) {
                params.pagination = {
                    el: '.swiper-pagination',
                    type: params.paginationType,
                    clickable: true
                };
            }

            // adding navigation
            if (params.navigation) {
                params.navigation = {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev',
                }
            }

            // adding lazy.loading
            params.lazy = {
                loadPrevNext: true,
            };

            // init slider with given parameters
            new Swiper(sliderElement, params);
        });
    }
})();
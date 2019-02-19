var initSwiper = function(sliderConfig) {
    // check if a sliderConfig was created inside the templates
    if (typeof Swiper !== 'undefined' && typeof sliderConfig !== 'undefined') {
        // get properties for this slider
        var sliderId = sliderConfig.id;
        var cssClass = sliderConfig.cssclass;
        var params = sliderConfig.params;
        var swiperClass = 'swiper-' + sliderId;

        // adjust html structure
        var slider = document.getElementById(sliderId);
        var sliderElement = slider.querySelector('.swiper-container');
        sliderElement.classList.add(swiperClass);
        var wrapperElement;
        // if there is an extra cssClass, try to select the element inside the container with this class
        if (cssClass) {
            wrapperElement = sliderElement.querySelector('.' + cssClass);
            // check if there is an element with this class
            if (!wrapperElement) {
                throw new Error('element with class "' + cssClass + '" not found!');
            }
            wrapperElement.classList.add('swiper-wrapper');
            // add custom css class
            //wrapperElement.classList.add(cssClass);
        } else {
            sliderElement.innerHTML = '<div class="swiper-wrapper">' + sliderElement.innerHTML + '</div>'; // add the swiper-wrapper element inside the swiper-container
            wrapperElement = sliderElement.querySelector('.swiper-wrapper');
        }
        // get all Elements inside the wrapper
        var slides = wrapperElement.children;
        for (var j = 0; j < slides.length; j++) {
            slides[j].classList.add('swiper-slide');
        }

        // adding pagination
        if (params.pagination) {
            params.pagination = {
                el: '.swiper-pagination-' + sliderId,
                type: params.paginationType,
                clickable: true
            };
        }

        // adding navigation
        if (params.navigation) {
            params.navigation = {
                nextEl: '.swiper-next-' + sliderId,
                prevEl: '.swiper-prev-' + sliderId,
            }
        }

        // adding lazy.loading
        params.lazy = {
            loadPrevNext: true,
        };

        // init slider with given parameters
        new Swiper(sliderElement, params);
    }
};

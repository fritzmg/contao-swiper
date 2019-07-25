var initSwiper = function(swiperConfig) {
    // check if a swiperConfig was created inside the templates
    if (typeof Swiper !== 'undefined' && typeof swiperConfig !== 'undefined') {
        // get properties for this slider
        var swiperId = swiperConfig.id;
        var wrapperClass = swiperConfig.wrapperClass;
        var params = swiperConfig.params;

        // adjust html structure
        var swiperContainer = document.getElementById(swiperId);
        var wrapperElement = swiperContainer.querySelector('.swiper-wrapper');

        // if there is an extra cssClass, try to select the element inside the container with this class
        if (wrapperClass) {
            newWrapperElement = swiperContainer.querySelector('.' + wrapperClass);
            // check if there is an element with this class
            if (!newWrapperElement) {
                throw new Error('Wrapper element with class "' + wrapperClass + '" not found!');
            }
            newWrapperElement.classList.add('swiper-wrapper');

            // remove original wrapper element
            while (wrapperElement.firstChild) {
                wrapperElement.parentNode.insertBefore(wrapperElement.firstChild, wrapperElement);
            }
            wrapperElement.parentNode.removeChild(wrapperElement);
            wrapperElement = newWrapperElement;

            // check if parent of swiper-wrapper is swiper-container
            var wrapperParent = wrapperElement.parentNode;
            if (!wrapperParent.classList.contains('swiper-container')) {
                // set parent of swiper-wrapper as swiper-container
                swiperContainer.parentNode.insertBefore(wrapperParent, swiperContainer);

                while (swiperContainer.firstChild) {
                    wrapperParent.appendChild(swiperContainer.firstChild);
                }
                
                wrapperParent.classList.add('swiper-container');
                wrapperParent.id = swiperContainer.id;

                swiperContainer.parentNode.removeChild(swiperContainer);
                swiperContainer = wrapperParent;
            }
        }

        // add swiper-slide class to all children
        var slides = wrapperElement.children;
        for (var j = 0; j < slides.length; j++) {
            slides[j].classList.add('swiper-slide');
        }

        // init slider with given parameters
        return new Swiper(swiperContainer, params);
    }
};

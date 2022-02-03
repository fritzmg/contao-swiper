<?php

/*
 * This file is part of the ContaoSwiper Bundle.
 *
 * (c) Fritz Michael Gschwantner <https://github.com/fritzmg>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace ContaoSwiperBundle\Renderer;

use Contao\ContentElement;
use Contao\ContentModel;
use Contao\LayoutModel;
use Contao\PageModel;
use Contao\StringUtil;
use Contao\Template;
use Symfony\Component\HttpFoundation\RequestStack;

class SwiperRenderer
{
    /**
     * @var RequestStack
     */
    private $requestStack;

    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    /**
     * @param ContentModel|ContentElement $model
     * @param array                       $classes
     *
     * @return array
     */
    public function addCssClasses($model, $classes)
    {
        if ($model->sliderButtons) {
            $classes[] = 'has-buttons';
        }

        if ($model->sliderPagination) {
            $classes[] = 'has-pagination';
        }

        if ($model->sliderPaginationType) {
            $classes[] = 'pagination-'.$model->sliderPaginationType;
        }

        if ($model->sliderSlidesPerView) {
            $classes[] = 'slides-per-view-'.$model->sliderSlidesPerView;
        }

        return $classes;
    }

    /**
     * @param Template     $template
     * @param ContentModel $model
     *
     * @return void
     */
    public function addParamsToTemplate($template, $model)
    {
        // default effect
        $model->sliderEffect = $model->sliderEffect ?: 'slide';

        // prepare parameters for swiper
        $params = [];

        // string for swiper id
        $swiperId = 'swiper-'.$model->id;

        // process parameters
        if ($model->sliderDelay) {
            $params['autoplay'] = ['delay' => (int) $model->sliderDelay];
        }

        if ($model->sliderSpeed) {
            $params['speed'] = (int) $model->sliderSpeed;
        }

        if ($model->sliderSlidesPerView && (is_numeric($model->sliderSlidesPerView) || 'auto' === $model->sliderSlidesPerView)) {
            $params['slidesPerView'] = is_numeric($model->sliderSlidesPerView) ? (int) $model->sliderSlidesPerView : $model->sliderSlidesPerView;
        }

        if ($model->sliderSpaceBetween) {
            $params['spaceBetween'] = (int) $model->sliderSpaceBetween;
        }

        if ('crossfade' === $model->sliderEffect) {
            $params['effect'] = 'fade';
            $params['fadeEffect'] = ['crossFade' => true];
        } elseif ($model->sliderEffect) {
            $params['effect'] = $model->sliderEffect;
        }

        if ($model->sliderContinuous) {
            $params['loop'] = true;
        }

        if ($model->sliderButtons) {
            $params['navigation'] = [
                'nextEl' => '#'.$swiperId.' .swiper-button-next',
                'prevEl' => '#'.$swiperId.' .swiper-button-prev',
            ];
        }

        if ($model->sliderPagination) {
            $params['pagination'] = [
                'el' => '#'.$swiperId.' .swiper-pagination',
                'clickable' => true,
            ];

            if ($model->sliderPaginationType) {
                // backwards compatibility
                $model->sliderPaginationType = 'progress' === $model->sliderPaginationType ? 'progressbar' : $model->sliderPaginationType;
                $params['pagination']['type'] = $model->sliderPaginationType;
            }
        }

        if ($model->sliderScrollbar) {
            $params['scrollbar'] = [
                'el' => '#'.$swiperId.' .swiper-scrollbar',
                'draggable' => true,
            ];
        }

        $breakpoints = StringUtil::deserialize($model->sliderBreakpoints, true);

        if (!empty($breakpoints)) {
            foreach ($breakpoints as $breakpoint) {
                $settings = [];

                if (is_numeric($breakpoint['slidesPerView']) || 'auto' === $breakpoint['slidesPerView']) {
                    $settings['slidesPerView'] = is_numeric($breakpoint['slidesPerView']) ? (int) $breakpoint['slidesPerView'] : 'auto';
                }

                if ($breakpoint['spaceBetween']) {
                    $settings['spaceBetween'] = (int) $breakpoint['spaceBetween'];
                }

                if (!empty($settings)) {
                    $params['breakpoints'][(int) $breakpoint['breakpoint']] = $settings;
                }
            }
        }

        if ($model->sliderAutoheight) {
            $params['autoHeight'] = true;
        }

        if ($model->sliderCenteredSlides) {
            $params['centeredSlides'] = true;
        }

        if ($model->sliderCustomOptions && null !== ($customOptions = json_decode($model->sliderCustomOptions, true))) {
            $params = array_replace_recursive($params, $customOptions);
        }

        $template->sliderButtons = $model->sliderButtons;
        $template->sliderPagination = $model->sliderPagination;
        $template->sliderScrollbar = $model->sliderScrollbar;
        $template->wrapperClass = $model->sliderWrapperClass;
        $template->parameters = $params;
        $template->sliderId = 'swiper-'.$model->id; // unique name for an entry in the sliderConfig-variable
    }

    /**
     * @return void
     */
    public function addAssets()
    {
        // check if the scripts should be combined
        $combine = '';

        // get the current page
        $page = null;
        $request = $this->requestStack->getCurrentRequest();

        if ($request) {
            /** @var PageModel $page */
            $page = $request->attributes->get('pageModel');
        }
        // if there is no request or "pageModel" is not part of the request-attributes
        // use the $GLOBALS['objPage']
        if (null === $page) {
            $page = $GLOBALS['objPage'];
        }
        // check if the page has a layout
        if ($page && $page->layout) {
            // get the current layout-model of the page
            if (null !== ($layout = LayoutModel::findById((int) $page->layout)) && $layout->add_swiper_scripts) {
                $combine = '|static';
            }
        }

        // add CSS and JS
        $GLOBALS['TL_CSS']['swiper'] = 'bundles/contaoswiper/swiper-bundle.min.css'.$combine;
        $GLOBALS['TL_JAVASCRIPT']['swiper'] = 'bundles/contaoswiper/swiper-bundle.min.js'.$combine; // load swiper
        $GLOBALS['TL_JAVASCRIPT']['swiper_init'] = 'bundles/contaoswiper/contao-swiper.min.js'.$combine; // load custom script to initialize the sliders
    }
}

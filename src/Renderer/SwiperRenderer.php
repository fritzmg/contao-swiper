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
use Contao\System;
use Contao\Template;

class SwiperRenderer
{
    /**
     * @param ContentModel|ContentElement $model
     * @param array                       $arrClasses
     *
     * @return array
     */
    public function addCssClasses($model, $arrClasses)
    {
        if ($model->sliderButtons)
        {
            $arrClasses[] = 'has-buttons';
        }
        if ($model->sliderPagination)
        {
            $arrClasses[] = 'has-pagination';
        }
        if ($model->sliderPaginationType)
        {
            $arrClasses[] = 'pagination-'.$model->sliderPaginationType;
        }
        if ($model->sliderSlidesPerView)
        {
            $arrClasses[] = 'slides-per-view-'.$model->sliderSlidesPerView;
        }

        return $arrClasses;
    }

    /**
     * @param Template     $template
     * @param ContentModel $model
     *
     * @return void
     */
    public function addParamsToTemplate($template, $objContent)
    {
        // default effect
        $objContent->sliderEffect = $objContent->sliderEffect ?: 'slide';

        // prepare parameters for swiper
        $arrParams = array();

        // string for swiper id
        $swiperId = 'swiper-' . $objContent->id;

        // process parameters
        if ($objContent->sliderDelay) $arrParams['autoplay'] = ['delay' => (int) $objContent->sliderDelay];
        if ($objContent->sliderSpeed) $arrParams['speed'] = (int) $objContent->sliderSpeed;
        if ($objContent->sliderSlidesPerView && (is_numeric($objContent->sliderSlidesPerView) || $objContent->sliderSlidesPerView == 'auto'))
            $arrParams['slidesPerView'] = is_numeric($objContent->sliderSlidesPerView) ? (int) $objContent->sliderSlidesPerView : $objContent->sliderSlidesPerView;
        if ($objContent->sliderSpaceBetween) $arrParams['spaceBetween'] = (int) $objContent->sliderSpaceBetween;
        if ('crossfade' === $objContent->sliderEffect) {
            $arrParams['effect'] = 'fade';
            $arrParams['fadeEffect'] = ['crossFade' => true];
        } elseif ($objContent->sliderEffect) {
            $arrParams['effect'] = $objContent->sliderEffect;
        }
        if ($objContent->sliderContinuous) $arrParams['loop'] = true;
        if ($objContent->sliderButtons)
        {
            $arrParams['navigation'] = [
                'nextEl' => '#' . $swiperId . ' .swiper-button-next',
                'prevEl' => '#' . $swiperId . ' .swiper-button-prev',
            ];
        }
        if ($objContent->sliderPagination)
        {
            $arrParams['pagination'] = [
                'el' => '#' . $swiperId . ' .swiper-pagination',
                'clickable' => true,
            ];

            if ($objContent->sliderPaginationType)
            {
                // backwards compatibility
                $objContent->sliderPaginationType = $objContent->sliderPaginationType === 'progress' ? 'progressbar' : $objContent->sliderPaginationType;
                $arrParams['pagination']['type'] = $objContent->sliderPaginationType;
            }
        }

        if ($objContent->sliderScrollbar) {
            $arrParams['scrollbar'] = [
                'el' => '#' . $swiperId . ' .swiper-scrollbar',
                'draggable' => true,
            ];
        }

        $arrBreakpoints = StringUtil::deserialize($objContent->sliderBreakpoints, true);

        if (!empty($arrBreakpoints)) {
            foreach ($arrBreakpoints as $arrBreakpoint) {
                $arrSettings = array();
                if (is_numeric($arrBreakpoint['slidesPerView']) || 'auto' == $arrBreakpoint['slidesPerView']) {
                    $arrSettings['slidesPerView'] = is_numeric($arrBreakpoint['slidesPerView']) ? (int)$arrBreakpoint['slidesPerView'] : 'auto';
                }
                if ($arrBreakpoint['spaceBetween']) {
                    $arrSettings['spaceBetween'] = (int)$arrBreakpoint['spaceBetween'];
                }
                if (!empty($arrSettings)) {
                    $arrParams['breakpoints'][(int)$arrBreakpoint['breakpoint']] = $arrSettings;
                }
            }
        }

        if ($objContent->sliderAutoheight) $arrParams['autoHeight'] = true;

        if ($objContent->sliderCenteredSlides) {
            $arrParams['centeredSlides'] = true;
        }

        if ($objContent->sliderCustomOptions && null !== ($customOptions = json_decode($objContent->sliderCustomOptions, true))) {
            $arrParams = array_replace_recursive($arrParams, $customOptions);
        }

        $template->sliderButtons    = $objContent->sliderButtons;
        $template->sliderPagination = $objContent->sliderPagination;
        $template->sliderScrollbar  = $objContent->sliderScrollbar;
        $template->wrapperClass     = $objContent->sliderWrapperClass;
        $template->parameters       = $arrParams;
        $template->sliderId         = 'swiper-' . $objContent->id; // unique name for an entry in the sliderConfig-variable
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
        $request = System::getContainer()->get('request_stack')->getCurrentRequest();
        if ($request) {
            /** @var PageModel $page */
            $page = $request->attributes->get('pageModel');
        }
        // if there is no request or "pageModel" is not part of the request-attributes
        // use the $GLOBALS['objPage']
        if ($page === null) {
            $page = $GLOBALS['objPage'];
        }
        // check if the page has a layout
        if ($page && $page->layout) {
            // get the current layout-model of the page
            if (null !== ($layout = LayoutModel::findById((int)$page->layout)) && $layout->add_swiper_scripts) {
                $combine = '|static';
            }
        }

        // add CSS and JS
        $GLOBALS['TL_CSS']['swiper'] = 'bundles/contaoswiper/swiper-bundle.min.css' . $combine;
        $GLOBALS['TL_JAVASCRIPT']['swiper'] = 'bundles/contaoswiper/swiper-bundle.min.js' . $combine; // load swiper
        $GLOBALS['TL_JAVASCRIPT']['swiper_init'] = 'bundles/contaoswiper/contao-swiper.min.js' . $combine; // load custom script to initialize the sliders
    }
}

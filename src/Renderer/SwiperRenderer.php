<?php

declare(strict_types=1);

/*
 * This file is part of the Contao Swiper Bundle.
 *
 * (c) inspiredminds
 *
 * @license LGPL-3.0-or-later
 */

namespace ContaoSwiperBundle\Renderer;

use Contao\ContentElement;
use Contao\ContentModel;
use Contao\CoreBundle\Framework\ContaoFramework;
use Contao\LayoutModel;
use Contao\Model;
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

    /**
     * @var ContaoFramework
     */
    private $framework;

    public function __construct(RequestStack $requestStack, ContaoFramework $framework)
    {
        $this->requestStack = $requestStack;
        $this->framework = $framework;
    }

    /**
     * @param ContentModel|ContentElement $model
     */
    public function addCssClasses($model, array $classes = []): array
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
     * @param ContentModel $model
     */
    public function addParamsToTemplate(Template $template, Model $model, $params = []): void
    {
        // default effect
        $model->sliderEffect = $model->sliderEffect ?: 'slide';

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

        $params = $this->addBreakpointsToParams($model, $params);

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
        $template->sliderId = $swiperId; // unique name for an entry in the sliderConfig-variable
    }

    public function addAssets(): void
    {
        // check if the scripts should be combined
        $combine = '';

        // check if the page has a layout
        if (null !== ($pageModel = $this->getPageModel()) && $pageModel->layout) {
            // get the current layout-model of the page
            if (null !== ($layout = $this->framework->getAdapter(LayoutModel::class)->findById((int) $pageModel->layout)) && $layout->add_swiper_scripts) {
                $combine = '|static';
            }
        }

        // add CSS and JS
        $GLOBALS['TL_CSS']['swiper'] = 'bundles/contaoswiper/swiper-bundle.min.css'.$combine;
        $GLOBALS['TL_JAVASCRIPT']['swiper'] = 'bundles/contaoswiper/swiper-bundle.min.js'.$combine; // load swiper
        $GLOBALS['TL_JAVASCRIPT']['swiper_init'] = 'bundles/contaoswiper/contao-swiper.min.js'.$combine; // load custom script to initialize the sliders
    }

    protected function getPageModel(): ?PageModel
    {
        $request = $this->requestStack->getCurrentRequest();

        if (null === $request || !$request->attributes->has('pageModel')) {
            return null;
        }

        $pageModel = $request->attributes->get('pageModel');

        if ($pageModel instanceof PageModel) {
            return $pageModel;
        }

        if (
            isset($GLOBALS['objPage'])
            && $GLOBALS['objPage'] instanceof PageModel
            && (int) $GLOBALS['objPage']->id === (int) $pageModel
        ) {
            return $GLOBALS['objPage'];
        }

        $this->framework->initialize();

        return $this->framework->getAdapter(PageModel::class)->findByPk((int) $pageModel);
    }

    protected function addBreakpointsToParams(Model $model, array $params): array
    {
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

        return $params;
    }
}

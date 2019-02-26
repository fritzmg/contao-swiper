<?php

/*
 * This file is part of the ContaoSwiper Bundle.
 *
 * (c) Fritz Michael Gschwantner <https://github.com/fritzmg>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ContaoSwiperBundle\Elements;

use Contao\BackendTemplate;
use Contao\ContentElement;
use Contao\ContentModel;
use Contao\LayoutModel;
use Contao\PageModel;
use Contao\System;


/**
 * Front end content element "swiper" (wrapper stop).
 *
 * @author Fritz Michael Gschwantner <fmg@inspiredminds.at>
 */
class WrapperStop extends ContentElement
{

	/**
	 * Template
	 * @var string
	 */
	protected $strTemplate = 'ce_swiperStop';


    /**
     * Display a wildcard in the back end.
     *
     * @return string
     */
    public function generate()
    {
        if (TL_MODE == 'BE')
        {
            $objTemplate = new BackendTemplate('be_wildcard');
            return $objTemplate->parse();
        }

        return parent::generate();
    }


	/**
	 * Generate the content element
	 */
	protected function compile()
	{
		$t = ContentModel::getTable();
		$objContent = ContentModel::findAll([
			'column' => [
				"$t.pid = ?",
				"$t.sorting < ?",
				"$t.type = ?"
			],
			'value' => [
				$this->pid,
				$this->sorting,
				'swiperStart'
			],
			'order'  => "$t.sorting DESC",
			'limit'   => 1,
			'return' => 'Model'
		]);

		if (null !== $objContent)
		{
			// default effect
			$objContent->sliderEffect = $objContent->sliderEffect ?: 'slide';

			// prepare parameters for swiper
			$arrParams = array();

			// process parameters
			if ($objContent->sliderDelay) $arrParams['autoplay'] = (int)$objContent->sliderDelay;
			if ($objContent->sliderSpeed) $arrParams['speed'] = (int)$objContent->sliderSpeed;
			if ($objContent->sliderSlidesPerView && (is_numeric($objContent->sliderSlidesPerView) || $objContent->sliderSlidesPerView == 'auto'))
				$arrParams['slidesPerView'] = is_numeric($objContent->sliderSlidesPerView) ? (int)$objContent->sliderSlidesPerView : $objContent->sliderSlidesPerView;
			if ($objContent->sliderSpaceBetween) $arrParams['spaceBetween'] = (int)$objContent->sliderSpaceBetween;
			if ($objContent->sliderEffect) $arrParams['effect'] = $objContent->sliderEffect;
			if ($objContent->sliderContinuous) $arrParams['loop'] = true;
			if ($objContent->sliderButtons)
			{
				// set navigation to true, so it will be enabled
				$arrParams['navigation'] = true;
			}
			if ($objContent->sliderPagination)
			{
				// set pagination to true, so it will be enabled
				$arrParams['pagination'] = true;
			}
			if ($objContent->sliderPaginationType)
			{
				$arrParams['paginationType'] = $objContent->sliderPaginationType === 'progress' ? 'progressbar' : $objContent->sliderPaginationType; // in swiper.js, the pagination-type is called "progressbar"
			}
			if ($arrBreakpoints = deserialize($objContent->sliderBreakpoints, true))
			{
				$arrParams['breakpoints'] = array();
				foreach ($arrBreakpoints as $arrBreakpoint)
				{
					$arrSettings = array();
					if (is_numeric($arrBreakpoint['slidesPerView']) || 'auto' == $arrBreakpoint['slidesPerView'])
					{
						$arrSettings['slidesPerView'] = is_numeric($arrBreakpoint['slidesPerView']) ? (int)$arrBreakpoint['slidesPerView'] : 'auto';
					}
					if ($arrBreakpoint['spaceBetween'])
					{
						$arrSettings['spaceBetween'] = (int)$arrBreakpoint['spaceBetween'];
					}
					$arrParams['breakpoints'][(int)$arrBreakpoint['breakpoint']] = $arrSettings;
				}
			}

			$this->Template->sliderButtons    = $objContent->sliderButtons;
			$this->Template->sliderPagination = $objContent->sliderPagination;
			$this->Template->wrapperClass     = $objContent->sliderWrapperClass;
			$this->Template->parameters       = $arrParams;
			$this->Template->sliderId         = 'swiper-' . $objContent->id; // unique name for an entry in the sliderConfig-variable

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
			$GLOBALS['TL_CSS'][] = 'bundles/contaoswiper/swiper.min.css' . $combine;
			$GLOBALS['TL_CSS'][] = 'bundles/contaoswiper/element.css' . $combine;
			$GLOBALS['TL_JAVASCRIPT']['swiper'] = 'bundles/contaoswiper/swiper.min.js' . $combine; // load swiper
			$GLOBALS['TL_JAVASCRIPT']['swiper_init'] = 'bundles/contaoswiper/contao-swiper.min.js' . $combine; // load custom script to initialize the sliders
		}
	}
}

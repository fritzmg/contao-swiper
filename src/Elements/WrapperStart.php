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

use Contao\ContentElement;
use Contao\BackendTemplate;
use Contao\FrontendTemplate;


/**
 * Front end content element "swiper" (wrapper start).
 *
 * @author Fritz Michael Gschwantner <fmg@inspiredminds.at>
 */
class WrapperStart extends ContentElement
{

	/**
	 * Template
	 * @var string
	 */
	protected $strTemplate = 'ce_swiperStart';


	/**
	 * Generate the content element
	 */
	protected function compile()
	{
		if (TL_MODE == 'BE')
		{
			$this->strTemplate = 'be_wildcard';

			/** @var BackendTemplate|object $objTemplate */
			$objTemplate = new BackendTemplate($this->strTemplate);

			$this->Template = $objTemplate;
			$this->Template->title = $this->headline;
		}

		// default effect
		$this->sliderEffect = $this->sliderEffect ?: 'slide';

		// prepare parameters for swiper
		$arrParams = array();

		// process parameters
		if ($this->sliderDelay) $arrParams['autoplay'] = (int)$this->sliderDelay;
		if ($this->sliderSpeed) $arrParams['speed'] = (int)$this->sliderSpeed;
		if ($this->sliderSlidesPerView && (is_numeric($this->sliderSlidesPerView) || $this->sliderSlidesPerView == 'auto'))
		  $arrParams['slidesPerView'] = is_numeric($this->sliderSlidesPerView) ? (int)$this->sliderSlidesPerView : $this->sliderSlidesPerView;
		if ($this->sliderSpaceBetween) $arrParams['spaceBetween'] = (int)$this->sliderSpaceBetween;
		if ($this->sliderEffect) $arrParams['effect'] = $this->sliderEffect;
		if ($this->sliderContinuous) $arrParams['loop'] = true;
		if ($this->sliderButtons)
		{
		  $arrParams['nextButton'] = '#swiper-'.$this->id.' .swiper-button-next';
		  $arrParams['prevButton'] = '#swiper-'.$this->id.' .swiper-button-prev';
		  $this->class .= ' has-buttons';
		}
		if ($this->sliderPagination)
		{
		  $arrParams['pagination'] = '#swiper-'.$this->id.' .swiper-pagination';
		  $arrParams['paginationClickable'] = true;
		  $this->class .= ' has-pagination';
		}
		if ($arrBreakpoints = deserialize($this->sliderBreakpoints, true))
		{
			$arrParams['breakpoints'] = array();
			foreach ($arrBreakpoints as $arrBreakpoint)
			{
				$arrSettings = array();
				if (is_numeric($arrBreakpoint['slidesPerView']) || 'auto' == $arrBreakpoint['slidesPerView'])
					$arrSettings['slidesPerView'] = $arrBreakpoint['slidesPerView'];
				if ($arrBreakpoint['spaceBetween'])
					$arrSettings['spaceBetween'] = $arrBreakpoint['spaceBetween'];
				$arrParams['breakpoints'][$arrBreakpoint['breakpoint']] = $arrSettings;
			}
		}

		// JavaScript template
		$objTemplate = new FrontendTemplate('jquery_swiper');
		$objTemplate->container = '#swiper-'.$this->id.' .swiper-container';
		$objTemplate->assignSlides = $this->sliderSlideClass ? false : true;
		$objTemplate->createWrapper = $this->sliderWrapperClass ? false : true;
		$objTemplate->wrapperClass = $this->sliderWrapperClass;
		$objTemplate->slideClass = $this->sliderSlideClass;
		$objTemplate->parameters = $arrParams;

		// add CSS and JS
		$GLOBALS['TL_CSS'][] = 'bundles/contaoswiper/swiper.min.css';
		$GLOBALS['TL_CSS'][] = 'bundles/contaoswiper/element.css';
		$GLOBALS['TL_JAVASCRIPT'][] = 'bundles/contaoswiper/swiper.jquery.min.js';
		$GLOBALS['TL_BODY'][] = $objTemplate->parse();
	}
}

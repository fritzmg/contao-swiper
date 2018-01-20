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
use Patchwork\Utf8;


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
				$arrParams['nextButton'] = '#swiper-'.$objContent->id.' .swiper-button-next';
				$arrParams['prevButton'] = '#swiper-'.$objContent->id.' .swiper-button-prev';
			}
			if ($objContent->sliderPagination)
			{
				$arrParams['pagination'] = '#swiper-'.$objContent->id.' .swiper-pagination';
				$arrParams['paginationClickable'] = true;
			}
			if ($objContent->sliderPaginationType)
			{
				$arrParams['paginationType'] = $objContent->sliderPaginationType;
			}
			if ($arrBreakpoints = deserialize($objContent->sliderBreakpoints, true))
			{
				$arrParams['breakpoints'] = array();
				foreach ($arrBreakpoints as $arrBreakpoint)
				{
					$arrSettings = array();
					if (is_numeric($arrBreakpoint['slidesPerView']) || 'auto' == $arrBreakpoint['slidesPerView'])
						$arrSettings['slidesPerView'] = is_numeric($arrBreakpoint['slidesPerView']) ? (int)$arrBreakpoint['slidesPerView'] : 'auto';
					if ($arrBreakpoint['spaceBetween'])
						$arrSettings['spaceBetween'] = (int)$arrBreakpoint['spaceBetween'];
					$arrParams['breakpoints'][$arrBreakpoint['breakpoint']] = $arrSettings;
				}
			}

			$this->Template->sliderButtons    = $objContent->sliderButtons;
			$this->Template->sliderPagination = $objContent->sliderPagination;
			$this->Template->container        = '#swiper-'.$objContent->id.' .swiper-container';
			$this->Template->wrapperClass     = $objContent->sliderWrapperClass;
			$this->Template->parameters       = $arrParams;

			// add CSS and JS
			$GLOBALS['TL_CSS'][] = 'bundles/contaoswiper/swiper.min.css';
			$GLOBALS['TL_CSS'][] = 'bundles/contaoswiper/element.css';
			$GLOBALS['TL_JAVASCRIPT'][] = 'bundles/contaoswiper/swiper.jquery.min.js';
		}
	}
}

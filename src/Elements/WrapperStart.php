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
		// additional css classes
		$arrClasses = explode(' ', $this->cssID[1]);

		if ($this->sliderButtons)
		{
			$arrClasses[] = 'has-buttons';
		}
		if ($this->sliderPagination)
		{
			$arrClasses[] = 'has-pagination';
		}
		if ($this->sliderPaginationType)
		{
			$arrClasses[] = 'pagination-'.$this->sliderPaginationType;
		}

		// set classes
		$arrCssID = $this->cssID;
		$arrCssID[1] = implode(' ', $arrClasses);
		$this->cssID = $arrCssID;
	}
}

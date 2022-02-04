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
use Contao\System;


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
     */
    public function generate(): string
    {
        if (TL_MODE === 'BE')
        {
            return (new BackendTemplate('be_wildcard'))->parse();
        }

        return parent::generate();
    }


	/**
	 * Generate the content element
	 */
	protected function compile(): void
	{
		// additional css classes
		$arrClasses = explode(' ', $this->cssID[1]);
        System::getContainer()->get('fritzmg.contao_swiper.renderer')->addCssClasses($this, $arrClasses);

		// set classes
		$arrCssID = $this->cssID;
		$arrCssID[1] = implode(' ', $arrClasses);
		$this->cssID = $arrCssID;
	}
}

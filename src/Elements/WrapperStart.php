<?php

declare(strict_types=1);

/*
 * This file is part of the Contao Swiper Bundle.
 *
 * (c) inspiredminds
 *
 * @license LGPL-3.0-or-later
 */

namespace ContaoSwiperBundle\Elements;

use Contao\BackendTemplate;
use Contao\ContentElement;
use Contao\System;

/**
 * Front end content element "swiper" (wrapper start).
 */
class WrapperStart extends ContentElement
{
    /**
     * Template.
     *
     * @var string
     */
    protected $strTemplate = 'ce_swiperStart';

    /**
     * Display a wildcard in the back end.
     */
    public function generate(): string
    {
        $request = System::getContainer()->get('request_stack')->getCurrentRequest();

        if ($request && System::getContainer()->get('contao.routing.scope_matcher')->isBackendRequest($request)) {
            return (new BackendTemplate('be_wildcard'))->parse();
        }

        return parent::generate();
    }

    /**
     * Generate the content element.
     */
    protected function compile(): void
    {
        // additional css classes
        $arrClasses = explode(' ', $this->cssID[1] ?? '');
        $arrClasses = System::getContainer()->get('fritzmg.contao_swiper.renderer')->addCssClasses($this, $arrClasses);

        // set classes
        $arrCssID = $this->cssID;
        $arrCssID[1] = implode(' ', $arrClasses);
        $this->cssID = $arrCssID;
    }
}

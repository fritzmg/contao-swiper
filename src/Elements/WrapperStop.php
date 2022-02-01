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
use Contao\StringUtil;
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
                "$t.ptable = ?",
                "$t.sorting < ?",
                "$t.type = ?",
            ],
            'value' => [
                $this->pid,
                $this->ptable,
                $this->sorting,
                'swiperStart',
            ],
            'order'  => "$t.sorting DESC",
            'limit'   => 1,
            'return' => 'Model'
        ]);

        if (null !== $objContent) {
            $swiperRenderer = System::getContainer()->get('fritzmg.contao_swiper.renderer');
            $swiperRenderer->addParamsToTemplate($this->Template, $objContent);
            $swiperRenderer->addAssets();
        }
    }
}

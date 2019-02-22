<?php

/*
 * This file is part of the ContaoSwiper Bundle.
 *
 * (c) Fritz Michael Gschwantner <https://github.com/fritzmg>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ContaoSwiperBundle\Resources\contao\dca;

use Contao\ArticleModel;
use Contao\ContentModel;
use Contao\DataContainer;
use Contao\LayoutModel;
use Contao\PageModel;

$GLOBALS['TL_DCA']['tl_content']['palettes']['swiperStart'] = '{type_legend},type;{slider_legend},sliderScripts,sliderDelay,sliderSpeed,sliderSlidesPerView,sliderSpaceBetween,sliderEffect,sliderWrapperClass,sliderContinuous,sliderButtons,sliderPagination,sliderPaginationType,sliderBreakpoints;{template_legend:hide},customTpl;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID;{invisible_legend:hide},invisible,start,stop';
$GLOBALS['TL_DCA']['tl_content']['palettes']['swiperStop'] = $GLOBALS['TL_DCA']['tl_content']['palettes']['sliderStop'];

$GLOBALS['TL_DCA']['tl_content']['fields']['sliderDelay']['eval']['rgxp'] = 'natural';
$GLOBALS['TL_DCA']['tl_content']['fields']['sliderDelay']['default'] = 7000;

$GLOBALS['TL_DCA']['tl_content']['fields']['sliderSpeed']['eval']['rgxp'] = 'natural';
$GLOBALS['TL_DCA']['tl_content']['fields']['sliderSpeed']['default'] = 700;

$GLOBALS['TL_DCA']['tl_content']['fields']['sliderContinuous']['eval']['tl_class'] = 'clr w50';

$GLOBALS['TL_DCA']['tl_content']['fields']['sliderSlidesPerView'] = array
(
	'label' => &$GLOBALS['TL_LANG']['tl_content']['sliderSlidesPerView'],
	'exclude' => true,
	'default' => 1,
	'inputType' => 'text',
	'eval' => array('maxlength'=>4, 'tl_class'=>'w50'),
	'sql' => "varchar(4) NOT NULL default '1'"
);

$GLOBALS['TL_DCA']['tl_content']['fields']['sliderSpaceBetween'] = array
(
	'label' => &$GLOBALS['TL_LANG']['tl_content']['sliderSpaceBetween'],
	'exclude' => true,
	'default' => 0,
	'inputType' => 'text',
	'eval' => array('rgxp'=>'natural', 'maxlength'=>5, 'tl_class'=>'w50'),
	'sql' => "int(10) unsigned NOT NULL default '0'"
);

$GLOBALS['TL_DCA']['tl_content']['fields']['sliderEffect'] = array
(
	'label' => &$GLOBALS['TL_LANG']['tl_content']['sliderEffect'],
	'exclude' => true,
	'default' => 'slide',
	'inputType' => 'select',
    'options' => array(
        'slide' => 'Slide',
        'fade' => 'Fade',
        'cube' => 'Cube',
        'coverflow' => 'Coverflow',
        'flip' => 'Flip'
    ),
	'eval' => array('tl_class'=>'w50'),
	'sql' => "varchar(16) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_content']['fields']['sliderWrapperClass'] = array
(
	'label' => &$GLOBALS['TL_LANG']['tl_content']['sliderWrapperClass'],
	'exclude' => true,
	'inputType' => 'text',
	'eval' => array('tl_class'=>'w50'),
	'sql' => "varchar(64) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_content']['fields']['sliderButtons'] = array
(
	'label' => &$GLOBALS['TL_LANG']['tl_content']['sliderButtons'],
	'exclude' => true,
	'inputType' => 'checkbox',
	'eval' => array('tl_class'=>'w50'),
	'sql' => "char(1) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_content']['fields']['sliderPagination'] = array
(
	'label' => &$GLOBALS['TL_LANG']['tl_content']['sliderPagination'],
	'exclude' => true,
	'inputType' => 'checkbox',
	'eval' => array('tl_class'=>'w50 m12'),
	'sql' => "char(1) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_content']['fields']['sliderPaginationType'] = array
(
    'label' => &$GLOBALS['TL_LANG']['tl_content']['sliderPaginationType'],
    'exclude' => true,
    'default' => 'bullets',
    'inputType' => 'select',
    'options' => array(
        'bullets' => 'Punkte',
        'fraction' => 'Bruchzahl',
        'progress' => 'Fortschritt'
    ),
    'eval' => array('tl_class'=>'w50'),
    'sql' => "varchar(16) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_content']['fields']['sliderBreakpoints'] = array
(
    'label'         => &$GLOBALS['TL_LANG']['tl_content']['sliderBreakpoints'],
    'exclude'       => true,
    'inputType'     => 'multiColumnWizard',
    'eval'          => array
     (
     	'tl_class' => 'clr',
        'columnFields' => array
        (
            'breakpoint' => array
            (
                'label'         => &$GLOBALS['TL_LANG']['tl_content']['sliderBreakpointsSettings']['breakpoint'],
                'exclude'       => true,
                'inputType'     => 'text',
                'eval'          => array('rgxp'=>'natural')
            ),
            'slidesPerView' => array
            (
                'label'         => &$GLOBALS['TL_LANG']['tl_content']['sliderBreakpointsSettings']['slidesPerView'],
                'exclude'       => true,
                'inputType'     => 'text',
                'eval'          => array('maxlength'=>4)
            ),
            'spaceBetween' => array
            (
                'label'         => &$GLOBALS['TL_LANG']['tl_content']['sliderBreakpointsSettings']['spaceBetween'],
                'exclude'       => true,
                'inputType'     => 'text',
                'eval'          => array('rgxp'=>'natural')
            ),
        )
    ),
    'sql' => 'BLOB null'
);

$GLOBALS['TL_DCA']['tl_content']['fields']['sliderScripts'] = [
	'label' => &$GLOBALS['TL_LANG']['tl_content']['sliderScripts'],
	'exclude' => true,
	'input_field_callback' => [tl_content_swiper::class, 'showScriptStatus'],
	'sql' => "char(1) NOT NULL default ''"
];

class tl_content_swiper
{
	/**
	 * @param DataContainer $dc
	 *
	 * @return string
	 */
	public function showScriptStatus(DataContainer $dc)
	{
		// get the content-model of the current record
		$content = ContentModel::findById((int)$dc->activeRecord->id);
		if (!$content) {
			throw new \RuntimeException('something went wrong!');
		}
		if ($content->type !== 'swiperStart') {
			return '';
		}

		// ptable for swiperStart is "tl_article"
		// get the article-model for the content-model
		$article = ArticleModel::findById((int)$content->pid);
		if (!$article) {
			throw new \RuntimeException('something went wrong!');
		}
		// get the page-model of the article-model
		$page = PageModel::findById((int)$article->pid);

		// if the page itself has no layout, check for a parent-page
		while ($page && !$page->includeLayout) {
			$page = PageModel::findById($page->pid);
		}
		if ($page && $page->layout) {
			$layout = LayoutModel::findById((int)$page->layout);
			// get the current layout-model of the page
			if (!$layout) {
				throw new \RuntimeException('something went wrong!');
			}
			$content->sliderScripts = $layout->add_swiper_scripts;
			$content->save();
		}
		return '<div class="widget clr"><h3><label>' . $GLOBALS['TL_LANG']['tl_content']['sliderScripts'][0] . '</label></h3><p class="tl_info">' . $GLOBALS['TL_LANG']['tl_content']['sliderScripts'][$content->sliderScripts ? 2 : 1] . '</p></div>';
	}
}

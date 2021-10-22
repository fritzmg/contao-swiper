<?php

/*
 * This file is part of the ContaoSwiper Bundle.
 *
 * (c) Fritz Michael Gschwantner <https://github.com/fritzmg>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


$GLOBALS['TL_DCA']['tl_content']['palettes']['swiperStart'] = '{type_legend},type;{slider_legend},sliderDelay,sliderSpeed,sliderSlidesPerView,sliderSpaceBetween,sliderEffect,sliderWrapperClass,sliderContinuous,sliderButtons,sliderAutoheight,sliderCenteredSlides,sliderScrollbar,sliderPagination,sliderBreakpoints;{template_legend:hide},customTpl;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID,sliderCustomOptions;{invisible_legend:hide},invisible,start,stop';

$GLOBALS['TL_DCA']['tl_content']['palettes']['__selector__'][] = 'sliderPagination';

$GLOBALS['TL_DCA']['tl_content']['subpalettes']['sliderPagination'] = 'sliderPaginationType';

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
        'crossfade' => 'Crossfade',
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

$GLOBALS['TL_DCA']['tl_content']['fields']['sliderScrollbar'] = array
(
    'label' => &$GLOBALS['TL_LANG']['tl_content']['sliderScrollbar'],
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
    'eval' => array('tl_class'=>'w50 clr', 'submitOnChange'=>true),
    'sql' => "char(1) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_content']['fields']['sliderPaginationType'] = array
(
    'label' => &$GLOBALS['TL_LANG']['tl_content']['sliderPaginationType'],
    'exclude' => true,
    'default' => 'bullets',
    'inputType' => 'select',
    'options' => array('bullets', 'fraction', 'progressbar'),
    'reference' => &$GLOBALS['TL_LANG']['tl_content']['sliderPaginationTypes'],
    'eval' => array('tl_class'=>'w50 clr'),
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

$GLOBALS['TL_DCA']['tl_content']['fields']['sliderAutoheight'] = array
(
    'label' => &$GLOBALS['TL_LANG']['tl_content']['sliderAutoheight'],
    'exclude' => true,
    'inputType' => 'checkbox',
    'eval' => array('tl_class'=>'w50'),
    'sql' => "char(1) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_content']['fields']['sliderCenteredSlides'] = array
(
    'label' => &$GLOBALS['TL_LANG']['tl_content']['sliderCenteredSlides'],
    'exclude' => true,
    'inputType' => 'checkbox',
    'eval' => array('tl_class'=>'w50'),
    'sql' => "char(1) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_content']['fields']['sliderCustomOptions'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_content']['sliderCustomOptions'],
    'exclude' => true,
    'inputType' => 'jsonWidget',
    'eval' => ['tl_class' => 'clr', 'rte' => 'ace|json', 'decodeEntities' => true, 'allowHtml' => true],
    'sql'       => "blob NULL",
];

<?php

/*
 * This file is part of the ContaoSwiper Bundle.
 *
 * (c) Fritz Michael Gschwantner <https://github.com/fritzmg>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Contao\StringUtil;

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
    'eval' => array('rgxp'=>'digit', 'maxlength'=>5, 'tl_class'=>'w50'),
    'sql' => ['type' => 'integer', 'unsigned' => false, 'default' => 0],
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

$GLOBALS['TL_DCA']['tl_content']['fields']['sliderBreakpoints'] = [
    'exclude'       => true,
    'inputType'     => 'group',
    'palette'       => ['breakpoint', 'slidesPerView', 'spaceBetween'],
    'eval'          => ['tl_class' => 'clr'],
    'fields' => [
        'breakpoint' => [
            'label'         => &$GLOBALS['TL_LANG']['tl_content']['sliderBreakpointsSettings']['breakpoint'],
            'inputType'     => 'text',
            'eval'          => array('rgxp'=>'natural', 'tl_class' => 'w50')
        ],
        'slidesPerView' => [
            'label'         => &$GLOBALS['TL_LANG']['tl_content']['sliderBreakpointsSettings']['slidesPerView'],
            'inputType'     => 'text',
            'eval'          => array('maxlength'=>4, 'tl_class' => 'clr w50')
        ],
        'spaceBetween' => [
            'label'         => &$GLOBALS['TL_LANG']['tl_content']['sliderBreakpointsSettings']['spaceBetween'],
            'inputType'     => 'text',
            'eval'          => array('rgxp'=>'digit', 'tl_class' => 'w50')
        ],
    ],
    'sql' => 'BLOB null'
];

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
    'inputType' => 'textarea',
    'eval' => ['tl_class' => 'clr', 'rte' => 'ace|json', 'decodeEntities' => true, 'allowHtml' => true],
    'sql'       => "blob NULL",
    'load_callback' => [static function($value) {
        if (empty($value)) {
            return null;
        }

        return json_encode(json_decode($value), JSON_PRETTY_PRINT) ?: null;
    }],
    'save_callback' => [static function($value) {
        $value = StringUtil::decodeEntities($value);

        if (empty($value)) {
            return null;
        }

        $value = json_decode($value);

        if (null === $value) {
            throw new \Exception($GLOBALS['TL_LANG']['ERR']['invalidJsonData']);
        }

        return json_encode($value);
    }],
];

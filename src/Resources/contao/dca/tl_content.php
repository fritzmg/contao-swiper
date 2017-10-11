<?php

/*
 * This file is part of the ContaoSwiper Bundle.
 *
 * (c) Fritz Michael Gschwantner <https://github.com/fritzmg>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


$GLOBALS['TL_DCA']['tl_content']['palettes']['swiperStart'] = '{type_legend},type,headline;{slider_legend},sliderDelay,sliderSpeed,sliderSlidesPerView,sliderSpaceBetween,sliderEffect,sliderWrapperClass,sliderContinuous,sliderButtons,sliderPagination,sliderPaginationType,sliderBreakpoints;{template_legend:hide},customTpl;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID;{invisible_legend:hide},invisible,start,stop';
$GLOBALS['TL_DCA']['tl_content']['palettes']['swiperStop'] = $GLOBALS['TL_DCA']['tl_content']['palettes']['sliderStop'];

$GLOBALS['TL_DCA']['tl_content']['fields']['sliderDelay']['eval']['rgxp'] = 'natural';
$GLOBALS['TL_DCA']['tl_content']['fields']['sliderDelay']['default'] = 7000;

$GLOBALS['TL_DCA']['tl_content']['fields']['sliderSpeed']['eval']['rgxp'] = 'natural';
$GLOBALS['TL_DCA']['tl_content']['fields']['sliderSpeed']['default'] = 700;

$GLOBALS['TL_DCA']['tl_content']['fields']['sliderContinuous']['eval']['tl_class'] = 'clr w50';

$GLOBALS['TL_DCA']['tl_content']['fields']['sliderSlidesPerView'] = array
(
	'label' => array('Anzahl der sichtbaren Slides','Die Anzahl an einzelnen Slides die pro Sektion sichtbar sein soll (Zahl oder \'auto\').'),
	'exclude' => true,
	'default' => 1,
	'inputType' => 'text',
	'eval' => array('maxlength'=>4, 'tl_class'=>'w50'),
	'sql' => "varchar(4) NOT NULL default '1'"
);

$GLOBALS['TL_DCA']['tl_content']['fields']['sliderSpaceBetween'] = array
(
	'label' => array('Abstand zwischen den Slides','Abstand zwischen den Slides in Pixel.'),
	'exclude' => true,
	'default' => 0,
	'inputType' => 'text',
	'eval' => array('rgxp'=>'natural', 'maxlength'=>5, 'tl_class'=>'w50'),
	'sql' => "int(10) unsigned NOT NULL default '0'"
);

$GLOBALS['TL_DCA']['tl_content']['fields']['sliderEffect'] = array
(
	'label' => array('Effekt','Effekt-Art beim Wechsel der Slides.'),
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
	'label' => array('Wrapper CSS Klasse','Die optionale CSS Klasse des Wrappers.'),
	'exclude' => true,
	'inputType' => 'text',
	'eval' => array('tl_class'=>'w50'),
	'sql' => "varchar(64) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_content']['fields']['sliderButtons'] = array
(
	'label' => array('Steuerschaltflächen','Zeigt Vor- und Zurück-Schaltflächen an.'),
	'exclude' => true,
	'inputType' => 'checkbox',
	'eval' => array('tl_class'=>'w50'),
	'sql' => "char(1) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_content']['fields']['sliderPagination'] = array
(
	'label' => array('Nummerierung','Zeigt eine klickbare Nummerierung für die einzelnen Slides an.'),
	'exclude' => true,
	'inputType' => 'checkbox',
	'eval' => array('tl_class'=>'w50 m12'),
	'sql' => "char(1) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_content']['fields']['sliderPaginationType'] = array
(
    'label' => array('Art der Nummerierung','Die Art der Nummerierung.'),
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
    'label'         => array('Breakpoints', 'Definiert andere Parameter bei spezifischen Viewport Breakpoints.'),
    'exclude'       => true,
    'inputType'     => 'multiColumnWizard',
    'eval'          => array
     (
     	'tl_class' => 'clr',
        'columnFields' => array
        (
            'breakpoint' => array
            (
                'label'         => array('Breakpoint', 'Der Breakpoint in Pixel.'),
                'exclude'       => true,
                'inputType'     => 'text',
                'eval'          => array('rgxp'=>'natural')
            ),
            'slidesPerView' => array
            (
                'label'         => array('Sichtbare Slides', 'Anzahl der sichtbaren Slides bei diesem Breakpoint.'),
                'exclude'       => true,
                'inputType'     => 'text',
                'eval'          => array('maxlength'=>4)
            ),
            'spaceBetween' => array
            (
                'label'         => array('Abstand', 'Abstand zwischen den Slides bei diesem Breapoint.'),
                'exclude'       => true,
                'inputType'     => 'text',
                'eval'          => array('rgxp'=>'natural')
            ),
        )
    ),
    'sql' => 'BLOB null'
);

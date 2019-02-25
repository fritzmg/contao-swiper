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

$table = 'tl_layout';

$GLOBALS['TL_DCA'][$table]['palettes']['default'] = str_replace('{script_legend}', '{script_legend},add_swiper_scripts', $GLOBALS['TL_DCA'][$table]['palettes']['default']);

$GLOBALS['TL_DCA'][$table]['fields']['add_swiper_scripts'] = [
	'label' => &$GLOBALS['TL_LANG'][$table]['add_swiper_scripts'],
	'exclude' => true,
	'inputType' => 'checkbox',
	'eval' => ['tl_class' => 'm12'],
	'sql' => "char(1) NOT NULL default ''"
];

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

use Contao\CoreBundle\DataContainer\PaletteManipulator;

$table = 'tl_layout';

PaletteManipulator::create()
	->addField('add_swiper_scripts', 'scripts', PaletteManipulator::POSITION_BEFORE)
	->applyToPalette('default', $table);

$GLOBALS['TL_DCA'][$table]['fields']['add_swiper_scripts'] = [
	'label' => &$GLOBALS['TL_LANG'][$table]['add_swiper_scripts'],
	'exclude' => true,
	'inputType' => 'checkbox',
	'eval' => ['tl_class' => 'm12'],
	'sql' => "char(1) NOT NULL default ''"
];

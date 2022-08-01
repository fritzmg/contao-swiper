<?php

declare(strict_types=1);

/*
 * This file is part of the Contao Swiper Bundle.
 *
 * (c) inspiredminds
 *
 * @license LGPL-3.0-or-later
 */

namespace ContaoSwiperBundle\Resources\contao\dca;

use Contao\CoreBundle\DataContainer\PaletteManipulator;

$table = 'tl_layout';

PaletteManipulator::create()
    ->addField('add_swiper_scripts', 'scripts', PaletteManipulator::POSITION_BEFORE)
    ->applyToPalette('default', $table)
;

$GLOBALS['TL_DCA'][$table]['fields']['add_swiper_scripts'] = [
    'label' => &$GLOBALS['TL_LANG'][$table]['add_swiper_scripts'],
    'exclude' => true,
    'inputType' => 'checkbox',
    'eval' => ['tl_class' => 'm12'],
    'sql' => "char(1) NOT NULL default ''",
];

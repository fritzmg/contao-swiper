<?php

declare(strict_types=1);

/*
 * This file is part of the Contao Swiper Bundle.
 *
 * (c) inspiredminds
 *
 * @license LGPL-3.0-or-later
 */

/*
 * Content elements
 */
$GLOBALS['TL_CTE']['slider']['swiperStart'] = 'ContaoSwiperBundle\Elements\WrapperStart';
$GLOBALS['TL_CTE']['slider']['swiperStop'] = 'ContaoSwiperBundle\Elements\WrapperStop';
unset($GLOBALS['TL_CTE']['slider']['sliderStart'], $GLOBALS['TL_CTE']['slider']['sliderStop']);

$GLOBALS['TL_LANG']['CTE']['swiperStart'] = &$GLOBALS['TL_LANG']['CTE']['sliderStart'];
$GLOBALS['TL_LANG']['CTE']['swiperStop'] = &$GLOBALS['TL_LANG']['CTE']['sliderStop'];

/*
 * Wrapper elements
 */
$GLOBALS['TL_WRAPPERS']['start'][] = 'swiperStart';
$GLOBALS['TL_WRAPPERS']['stop'][] = 'swiperStop';

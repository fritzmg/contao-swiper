<?php

/*
 * This file is part of the ContaoSwiper Bundle.
 *
 * (c) Fritz Michael Gschwantner <https://github.com/fritzmg>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


/**
 * Content elements
 */
$GLOBALS['TL_CTE']['slider']['swiperStart'] = 'ContaoSwiperBundle\Elements\WrapperStart';
$GLOBALS['TL_CTE']['slider']['swiperStop'] = 'ContaoSwiperBundle\Elements\WrapperStop';
unset($GLOBALS['TL_CTE']['slider']['sliderStart']);
unset($GLOBALS['TL_CTE']['slider']['sliderStop']);
$GLOBALS['TL_LANG']['CTE']['swiperStart'] = &$GLOBALS['TL_LANG']['CTE']['sliderStart'];
$GLOBALS['TL_LANG']['CTE']['swiperStop'] = &$GLOBALS['TL_LANG']['CTE']['sliderStop'];


/**
 * Wrapper elements
 */
$GLOBALS['TL_WRAPPERS']['start'][] = 'swiperStart';
$GLOBALS['TL_WRAPPERS']['stop'][] = 'swiperStop';

<?php

declare(strict_types=1);

/*
 * This file is part of the Contao Swiper Bundle.
 *
 * (c) inspiredminds
 *
 * @license LGPL-3.0-or-later
 */

$GLOBALS['TL_LANG']['tl_content']['sliderSlidesPerView'] = ['Slides per view', "Number of visible slides (a natural number or 'auto')."];
$GLOBALS['TL_LANG']['tl_content']['sliderSpaceBetween'] = ['Space between', 'Space between slides in pixels.'];
$GLOBALS['TL_LANG']['tl_content']['sliderEffect'] = ['Effect', 'The transition effect.'];
$GLOBALS['TL_LANG']['tl_content']['sliderWrapperClass'] = ['Wrapper CSS class', 'Optional definition of the wrapper (useful if the slider is wrapped around a module for example). Can be used when you want to slide through a news-list. Then the class of the list-container must be specified (mod_newslist).'];
$GLOBALS['TL_LANG']['tl_content']['sliderButtons'] = ['Prev/next buttons', 'Shows the prev/next buttons.'];
$GLOBALS['TL_LANG']['tl_content']['sliderScrollbar'] = ['Scrollbar', 'Shows a dragabble scrollbar.'];
$GLOBALS['TL_LANG']['tl_content']['sliderPagination'] = ['Pagination', 'Shows a clickable pagination to navigate the slides.'];
$GLOBALS['TL_LANG']['tl_content']['sliderPaginationType'] = ['Pagination type', 'The type of the pagination.'];
$GLOBALS['TL_LANG']['tl_content']['sliderAutoheight'] = ['Auto-height', 'When active the height of the slider adapts to the height of the currently active element.'];
$GLOBALS['TL_LANG']['tl_content']['sliderCenteredSlides'] = ['Centered slides', 'When active the current slide will be in the center of the slider rathern than aligned to the left.'];
$GLOBALS['TL_LANG']['tl_content']['sliderBreakpoints'] = ['Breakpoints', 'Overrides certain parameters at the defined viewport breakpoints.'];
$GLOBALS['TL_LANG']['tl_content']['sliderCustomOptions'] = ['Custom options', 'Custom options for the Swiper instance as JSON.'];

$GLOBALS['TL_LANG']['tl_content']['sliderBreakpointsSettings']['breakpoint'] = ['Breakpoint', 'The breakpoint in pixels.'];
$GLOBALS['TL_LANG']['tl_content']['sliderBreakpointsSettings']['slidesPerView'] = ['Slides per view', 'Number of visible slides at this breakpoint.'];
$GLOBALS['TL_LANG']['tl_content']['sliderBreakpointsSettings']['spaceBetween'] = ['Space between', 'Space between slides at this breakpoint.'];

$GLOBALS['TL_LANG']['tl_content']['sliderPaginationTypes'] = [
    'bullets' => 'Bullets',
    'fraction' => 'Fraction',
    'progressbar' => 'Progress bar',
];

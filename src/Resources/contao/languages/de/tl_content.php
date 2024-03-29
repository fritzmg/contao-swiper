<?php

declare(strict_types=1);

/*
 * This file is part of the Contao Swiper Bundle.
 *
 * (c) inspiredminds
 *
 * @license LGPL-3.0-or-later
 */

$GLOBALS['TL_LANG']['tl_content']['sliderSlidesPerView'] = ['Anzahl der sichtbaren Slides', "Die Anzahl an einzelnen Slides die pro Sektion sichtbar sein soll (Zahl oder 'auto')."];
$GLOBALS['TL_LANG']['tl_content']['sliderSpaceBetween'] = ['Abstand zwischen den Slides', 'Abstand zwischen den Slides in Pixel.'];
$GLOBALS['TL_LANG']['tl_content']['sliderEffect'] = ['Effekt', 'Effekt-Art beim Wechsel der Slides.'];
$GLOBALS['TL_LANG']['tl_content']['sliderWrapperClass'] = ['Wrapper CSS Klasse', 'Die optionale CSS Klasse des Wrappers. Kann verwendet werden, wenn man z.B. durch eine Nachrichtenliste sliden möchte. Dann muss die Klasse des Listen-Containers angegeben werden (mod_newslist).'];
$GLOBALS['TL_LANG']['tl_content']['sliderButtons'] = ['Steuerschaltflächen', 'Zeigt Vor- und Zurück-Schaltflächen an.'];
$GLOBALS['TL_LANG']['tl_content']['sliderScrollbar'] = ['Scroll-Balken', 'Zeigt einen Scroll-Balken an.'];
$GLOBALS['TL_LANG']['tl_content']['sliderPagination'] = ['Nummerierung', 'Zeigt eine klickbare Nummerierung für die einzelnen Slides an.'];
$GLOBALS['TL_LANG']['tl_content']['sliderPaginationType'] = ['Art der Nummerierung', 'Die Art der Nummerierung.'];
$GLOBALS['TL_LANG']['tl_content']['sliderAutoheight'] = ['Automatische Höhe', 'Wenn aktiv, passt sich die Höhe des Sliders an die Höhe des aktuell aktiven Elements an.'];
$GLOBALS['TL_LANG']['tl_content']['sliderCenteredSlides'] = ['Zentrierte Slides', 'Zentriert den gerade aktiven Slide, anstatt ihn links auszurichten.'];
$GLOBALS['TL_LANG']['tl_content']['sliderBreakpoints'] = ['Breakpoints', 'Definiert andere Parameter bei spezifischen Viewport Breakpoints.'];
$GLOBALS['TL_LANG']['tl_content']['sliderCustomOptions'] = ['Eigene Optionen', 'Eigene Optionen für die Swiper Instanz als JSON.'];

$GLOBALS['TL_LANG']['tl_content']['sliderBreakpointsSettings']['breakpoint'] = ['Breakpoint', 'Der Breakpoint in Pixel.'];
$GLOBALS['TL_LANG']['tl_content']['sliderBreakpointsSettings']['slidesPerView'] = ['Sichtbare Slides', 'Anzahl der sichtbaren Slides bei diesem Breakpoint.'];
$GLOBALS['TL_LANG']['tl_content']['sliderBreakpointsSettings']['spaceBetween'] = ['Abstand', 'Abstand zwischen den Slides bei diesem Breakpoint.'];

$GLOBALS['TL_LANG']['tl_content']['sliderPaginationTypes'] = [
    'bullets' => 'Punkte',
    'fraction' => 'Bruchzahl',
    'progressbar' => 'Fortschritt',
];

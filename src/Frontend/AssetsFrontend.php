<?php

/*
 * This file is part of the ContaoSwiper Bundle.
 *
 * (c) Fritz Michael Gschwantner <https://github.com/fritzmg>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ContaoSwiperBundle\Frontend;

use Contao\LayoutModel;
use Contao\PageModel;
use Symfony\Component\HttpFoundation\RequestStack;

class AssetsFrontend
{
    /**
     * @var RequestStack
     */
    private $requestStack;

    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    /**
     * @return void
     */
    public function addAssets()
    {
        // check if the scripts should be combined
        $combine = '';

        // get the current page
        $page = null;
        $request = $this->requestStack->getCurrentRequest();
        if ($request) {
            /** @var PageModel $page */
            $page = $request->attributes->get('pageModel');
        }
        // if there is no request or "pageModel" is not part of the request-attributes
        // use the $GLOBALS['objPage']
        if ($page === null) {
            $page = $GLOBALS['objPage'];
        }
        // check if the page has a layout
        if ($page && $page->layout) {
            // get the current layout-model of the page
            if (null !== ($layout = LayoutModel::findById((int)$page->layout)) && $layout->add_swiper_scripts) {
                $combine = '|static';
            }
        }

        // add CSS and JS
        $GLOBALS['TL_CSS']['swiper'] = 'bundles/contaoswiper/swiper-bundle.min.css' . $combine;
        $GLOBALS['TL_JAVASCRIPT']['swiper'] = 'bundles/contaoswiper/swiper-bundle.min.js' . $combine; // load swiper
        $GLOBALS['TL_JAVASCRIPT']['swiper_init'] = 'bundles/contaoswiper/contao-swiper.min.js' . $combine; // load custom script to initialize the sliders
    }
}

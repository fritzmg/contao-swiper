<?php

/*
 * This file is part of the ContaoSwiper Bundle.
 *
 * (c) Fritz Michael Gschwantner <https://github.com/fritzmg>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ContaoSwiperBundle\Helper;

use Contao\ArticleModel;
use Contao\ContentModel;
use Contao\DataContainer;
use Contao\LayoutModel;
use Contao\PageModel;

class DcaHelper
{
    /**
	 * get all pages (also subpages) and update the swiper-config
	 *
	 * @param DataContainer $dc
	 */
    public function saveLayoutSettings(DataContainer $dc)
    {
        $pages = PageModel::findByLayout((int)$dc->activeRecord->id);
		if ($pages) {
			/** @var PageModel $page */
			foreach ($pages as $page) {
				// update the swiper-config for all the pages with this layout-Id
				$this->updateSwiperConfig((int)$page->id, $dc);

				// update the swiper-config for all the child-pages, that do not have a different layout
				$subPages = PageModel::findBy(['pid = ?', 'includeLayout = ?'], [(int)$page->id, '']);
				if ($subPages) {
					/** @var PageModel $subPage */
					foreach ($subPages as $subPage) {
						$this->updateSwiperConfig((int)$subPage->id, $dc);
					}
				}
			}
		}
    }

    /**
	 * loop through all articles for each page and update the swiper-content
	 *
	 * @param int $pageId
	 * @param DataContainer $dc
	 */
	private function updateSwiperConfig($pageId, DataContainer $dc)
	{
		$articles = ArticleModel::findByPid($pageId);
		if ($articles) {
			/** @var ArticleModel $article */
			foreach ($articles as $article) {
				$contents = ContentModel::findBy(['pid = ?', 'ptable = ?', 'type = ?'], [(int)$article->id, 'tl_article', 'swiperStart']);
				if ($contents) {
					/** @var ContentModel $content */
					foreach ($contents as $content) {
						$content->sliderScripts = $dc->activeRecord->add_swiper_scripts;
						$content->save();
					}
				}
			}
		}
	}

    /**
     * check the swiper-setting of the currently used layout
     * 
	 * @param DataContainer $dc
	 */
    public function saveSwiperSetting(DataContainer $dc)
    {
        // get the content-model of the current record
		$content = ContentModel::findById((int)$dc->activeRecord->id);
		if (!$content) {
			throw new \RuntimeException('something went wrong!');
		}
		if ($content->type !== 'swiperStart') {
			return '';
		}

		// ptable for swiperStart is "tl_article"
		// get the article-model for the content-model
		$article = ArticleModel::findById((int)$content->pid);
		if (!$article) {
			throw new \RuntimeException('something went wrong!');
		}
		// get the page-model of the article-model
		$page = PageModel::findById((int)$article->pid);

		// if the page itself has no layout, check for a parent-page
		while ($page && !$page->includeLayout) {
			$page = PageModel::findById($page->pid);
		}
		if ($page && $page->layout) {
			$layout = LayoutModel::findById((int)$page->layout);
			// get the current layout-model of the page
			if (!$layout) {
				throw new \RuntimeException('something went wrong!');
			}
			$content->sliderScripts = $layout->add_swiper_scripts;
			$content->save();
		}
    }
}

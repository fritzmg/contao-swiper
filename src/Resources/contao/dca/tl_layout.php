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

use Contao\ArticleModel;
use Contao\ContentModel;
use Contao\DataContainer;
use Contao\PageModel;

$table = 'tl_layout';

// adding submit-callback to update the swiper-configurations for all the pages with this layout
$GLOBALS['TL_DCA'][$table]['config']['onsubmit_callback'][] = [tl_layout_swiper::class, 'saveSwiperConfig'];

$GLOBALS['TL_DCA'][$table]['palettes']['default'] = str_replace('{script_legend}', '{script_legend},add_swiper_scripts', $GLOBALS['TL_DCA'][$table]['palettes']['default']);

$GLOBALS['TL_DCA'][$table]['fields']['add_swiper_scripts'] = [
	'label' => &$GLOBALS['TL_LANG'][$table]['add_swiper_scripts'],
	'exclude' => true,
	'inputType' => 'checkbox',
	'eval' => ['tl_class' => 'm12'],
	'sql' => "char(1) NOT NULL default ''"
];

class tl_layout_swiper
{
	/**
	 * get all pages (also subpages) and update the swiper-config
	 *
	 * @param DataContainer $dc
	 */
	public function saveSwiperConfig(DataContainer $dc)
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
}

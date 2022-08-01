<?php

declare(strict_types=1);

/*
 * This file is part of the Contao Swiper Bundle.
 *
 * (c) inspiredminds
 *
 * @license LGPL-3.0-or-later
 */

namespace InspiredMinds\ContaoSwiperBundle\Migration;

use Contao\CoreBundle\Migration\AbstractMigration;
use Contao\CoreBundle\Migration\MigrationResult;
use Contao\StringUtil;
use Doctrine\DBAL\Connection;

class GroupWidgetMigration extends AbstractMigration
{
    private $db;

    public function __construct(Connection $db)
    {
        $this->db = $db;
    }

    public function shouldRun(): bool
    {
        $schemaManager = $this->db->getSchemaManager();

        if (!$schemaManager->tablesExist(['tl_content'])) {
            return false;
        }

        $columns = $schemaManager->listTableColumns('tl_content');

        if (!isset($columns['sliderbreakpoints'])) {
            return false;
        }

        return (int) $this->db->fetchOne("SELECT COUNT(*) FROM tl_content WHERE sliderBreakpoints LIKE 'a:1:{i:0;%'") > 0;
    }

    public function run(): MigrationResult
    {
        foreach ($this->db->fetchAllAssociative("SELECT * FROM tl_content WHERE sliderBreakpoints LIKE 'a:1:{i:0;%'") as $field) {
            $templates = [];

            foreach (StringUtil::deserialize($field['sliderBreakpoints'], true) as $key => $template) {
                if (is_numeric($key)) {
                    $key = $key + 1;
                }

                $templates[$key] = $template;
            }

            $this->db->update('tl_content', ['sliderBreakpoints' => serialize($templates)], ['id' => $field['id']]);
        }

        return $this->createResult(true);
    }
}

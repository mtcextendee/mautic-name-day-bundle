<?php

namespace MauticPlugin\MauticNameDayBundle;

use Mautic\CoreBundle\Factory\MauticFactory;
use Mautic\PluginBundle\Bundle\PluginBundleBase;
use Mautic\PluginBundle\Entity\Plugin;
use MauticPlugin\MauticNameDayBundle\Enum\CountryEnum;
use MauticPlugin\MauticNameDayBundle\Enum\SettingsKeyEnum;

class MauticNameDayBundle extends PluginBundleBase
{

    /**
     * Called by PluginController::reloadAction when adding a new plugin that's not already installed
     *
     * @param Plugin        $plugin
     * @param MauticFactory $factory
     * @param null          $metadata
     */

    public static function onPluginInstall(
        Plugin $plugin,
        MauticFactory $factory,
        $metadata = null,
        $installedSchema = null
    ) {
        if ($metadata === null) {
            $metadata = self::getMetadata($factory->getEntityManager());
        }

        if ($metadata !== null) {
            parent::onPluginInstall($plugin, $factory, $metadata, $installedSchema);
            $db = $factory->getDatabase();

            foreach (SettingsKeyEnum::getSupportedCountries() as $supportedCountry) {
                self::importDataToTable($db, $supportedCountry);
            }

        }
    }

    /**
     * @param \Doctrine\DBAL\Connection $db
     * @param string                    $country
     *
     * @throws \Doctrine\DBAL\ConnectionException
     */
    private static function importDataToTable(\Doctrine\DBAL\Connection $db, $country)
    {
        $countyEnum = (new CountryEnum($country));
        $sql        = file_get_contents(sprintf("%s/Data/%s.sql", __DIR__, $countyEnum->getTableName()));
        if ($sql) {
            $sql = str_replace(
                $countyEnum->getTableName(),
                sprintf("%s%s", MAUTIC_TABLE_PREFIX, $countyEnum->getTableName()),
                $sql
            );
            $db->beginTransaction();
            try {
                $db->query($sql);
                $db->commit();
            } catch (\Exception $e) {
                $db->rollback();
                // throw $e;
            }
        }
    }

}

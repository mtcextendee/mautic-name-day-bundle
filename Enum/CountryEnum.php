<?php

/*
 * @copyright   2019 Mautic Contributors. All rights reserved
 * @author      MTCExtendee.com
 *
 * @link        http://mautic.org
 *
 * @license     GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */

namespace MauticPlugin\MauticNameDayBundle\Enum;

final class CountryEnum
{
    private $country;

    /**
     * CountryEnum constructor.
     *
     * @param string $country
     */
    public function __construct($country)
    {
        $this->country = $country;
    }

    /**
     * @return string
     */
    public function getTableName()
    {
        switch ($this->country) {
            case SettingsKeyEnum::SLOVAKIA:
            case SettingsKeyEnum::CZECH:
            return sprintf("%s_%s", SettingsKeyEnum::TABLE_NAME, strtolower($this->country));
        }
    }
    /**
     * @return string
     */
    public function getIntegrationName()
    {
        switch ($this->country) {
            case SettingsKeyEnum::SLOVAKIA:
            case SettingsKeyEnum::CZECH:
                return sprintf("%s%s", SettingsKeyEnum::INTEGRATION_NAME, $this->country);
        }
    }

    /**
     * @return string
     */
    public function getCountryName()
    {
        return $this->country;
    }

}

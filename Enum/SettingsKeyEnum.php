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

final class SettingsKeyEnum
{
    CONST TABLE_NAME = 'name_day_calendar';
    CONST INTEGRATION_NAME = 'NameDay';

    CONST SLOVAKIA = 'Slovakia';
    CONST CZECH = 'Czech';

    /**
     * @return array
     */
    public static function getSupportedCountries()
    {
        return [self::SLOVAKIA, self::CZECH];
    }


}

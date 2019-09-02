<?php

/*
 * @copyright   2019 Mautic Contributors. All rights reserved
 * @author      MTCExtendee.com
 *
 * @link        http://mautic.org
 *
 * @license     GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */

namespace MauticPlugin\MauticNameDayBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Mautic\ApiBundle\Serializer\Driver\ApiMetadataDriver;
use Mautic\CoreBundle\Doctrine\Mapping\ClassMetadataBuilder;
use MauticPlugin\MauticNameDayBundle\Enum\CountryEnum;
use MauticPlugin\MauticNameDayBundle\Enum\SettingsKeyEnum;

class SlovakiaName
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    private $day;


    /**
     * @var string
     */
    private $names;

    /**
     * @param ORM\ClassMetadata $metadata
     */
    public static function loadMetadata(ORM\ClassMetadata $metadata)
    {
        $countryEnum = new CountryEnum(SettingsKeyEnum::SLOVAKIA);
        $builder = new ClassMetadataBuilder($metadata);
        $builder->setTable($countryEnum->getTableName())
            ->setCustomRepositoryClass(SlovakiaNameRepository::class)
            ->addId()
            ->addIndex(['day'], 'day');

        $builder->createField('day', 'string')
            ->columnName('day')
            ->nullable()
            ->build();

        $builder->createField('names', 'string')
            ->columnName('names')
            ->nullable()
            ->build();
    }

    /**
     * Prepares the metadata for API usage.
     *
     * @param $metadata
     */
    public static function loadApiMetadata(ApiMetadataDriver $metadata)
    {
        $countryEnum = new CountryEnum(SettingsKeyEnum::SLOVAKIA);
        $metadata->setGroupPrefix($countryEnum->getTableName())
            ->addListProperties(
                [
                    'id',
                    'date',
                    'names',
                ]
            )
            ->build();
    }

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getNames()
    {
        return $this->names;
    }

    /**
     * @param string $names
     *
     * @return SlovakiaName
     */
    public function setNames($names)
    {
        $this->names = $names;

        return $this;
}

    /**
     * @return string
     */
    public function getDay()
    {
        return $this->day;
    }

    /**
     * @param string $day
     *
     * @return SlovakiaName
     */
    public function setDay($day)
    {
        $this->day = $day;

        return $this;
}
}
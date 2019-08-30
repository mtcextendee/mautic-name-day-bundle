<?php

/*
 * @copyright   2019 Mautic Contributors. All rights reserved
 * @author      Mautic
 *
 * @link        http://mautic.org
 *
 * @license     GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */

namespace MauticPlugin\MauticNameDayBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Mautic\ApiBundle\Serializer\Driver\ApiMetadataDriver;
use Mautic\CoreBundle\Doctrine\Mapping\ClassMetadataBuilder;

class Name
{
    const TABLE = 'name_day_calendar';

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
        $builder = new ClassMetadataBuilder($metadata);
        $builder->setTable(self::TABLE)
            ->setCustomRepositoryClass(NameRepository::class)
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
        $metadata->setGroupPrefix(self::TABLE)
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
     * @return Name
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
     * @return Name
     */
    public function setDay($day)
    {
        $this->day = $day;

        return $this;
}
}
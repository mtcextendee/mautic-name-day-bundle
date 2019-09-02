<?php

namespace MauticPlugin\MauticNameDayBundle\Integration;

use Mautic\PluginBundle\Integration\AbstractIntegration;
use MauticPlugin\MauticNameDayBundle\Enum\CountryEnum;
use MauticPlugin\MauticNameDayBundle\Enum\SettingsKeyEnum;

class NameDaySlovakiaIntegration extends AbstractIntegration
{
    /**
     * @var CountryEnum
     */
    private $countryEnum;

    public function __construct()
    {
        $this->countryEnum = new CountryEnum(SettingsKeyEnum::SLOVAKIA);
        parent::__construct();
    }

    public function getName()
    {
        return $this->countryEnum->getIntegrationName();
    }

    public function getDisplayName()
    {
        return 'Slovakia Names Day';
    }

    public function getAuthenticationType()
    {
        /* @see \Mautic\PluginBundle\Integration\AbstractIntegration::getAuthenticationType */
        return 'none';
    }

    /**
     * Get icon for Integration.
     *
     * @return string
     */
    public function getIcon()
    {
        return sprintf("plugins/MauticNameDayBundle/Assets/img/%s.png", $this->countryEnum->getCountryName());
    }

    /**
     * @param \Mautic\PluginBundle\Integration\Form|FormBuilder $builder
     * @param array                                             $data
     * @param string                                            $formArea
     */
    public function appendToForm(&$builder, $data, $formArea)
    {
        if ($formArea == 'keys') {
        }
    }
}

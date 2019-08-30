<?php

namespace MauticPlugin\MauticNameDayBundle\Integration;

use Mautic\PluginBundle\Integration\AbstractIntegration;

class NameDayIntegration extends AbstractIntegration
{
    public function getName()
    {
        // should be the name of the integration
        return 'NameDay';
    }

    public function getDisplayName()
    {
        return 'Slovakia Name Day';
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
        return 'plugins/MauticNameDayBundle/Assets/img/icon.png';
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

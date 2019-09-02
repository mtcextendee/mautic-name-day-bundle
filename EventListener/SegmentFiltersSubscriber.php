<?php

/*
 * @copyright   2019 Mautic Contributors. All rights reserved
 * @author      MTCExtendee.com
 *
 * @link        http://mautic.org
 *
 * @license     GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */

namespace MauticPlugin\MauticNameDayBundle\EventListener;

use Mautic\CoreBundle\Event\BuildJsEvent;
use Mautic\CoreBundle\EventListener\CommonSubscriber;
use Mautic\CoreBundle\Helper\DateTimeHelper;
use Mautic\LeadBundle\Event\LeadListFilteringEvent;
use Mautic\LeadBundle\Event\LeadListFiltersChoicesEvent;
use Mautic\LeadBundle\LeadEvents;
use Mautic\PluginBundle\Helper\IntegrationHelper;
use MauticPlugin\MauticNameDayBundle\Enum\CountryEnum;
use MauticPlugin\MauticNameDayBundle\Enum\SettingsKeyEnum;

class SegmentFiltersSubscriber extends CommonSubscriber
{

    /**
     * @var IntegrationHelper
     */
    private $integrationHelper;

    public function __construct(IntegrationHelper $integrationHelper)
    {
        $this->integrationHelper = $integrationHelper;
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
            LeadEvents::LIST_FILTERS_CHOICES_ON_GENERATE => [
                ['onListFiltersGenerate', 0],
            ],

            LeadEvents::LIST_FILTERS_ON_FILTERING => [
                ['onListFiltersFiltering', 0],
            ],
        ];
    }


    /**
     * @param BuildJsEvent $event
     */
    public function onListFiltersGenerate(LeadListFiltersChoicesEvent $event)
    {
        if (in_array($this->request->attributes->get('_route'), ['mautic_segment_action'])) {
            foreach (SettingsKeyEnum::getSupportedCountries() as $supportedCountry) {
                $countryEnum = new CountryEnum($supportedCountry);
                $myIntegration = $this->integrationHelper->getIntegrationObject($countryEnum->getIntegrationName());
                if (false === $myIntegration || !$myIntegration->getIntegrationSettings()->getIsPublished()) {
                    continue;
                }

                $properties = ['type' => 'bool'];
                $options    = [
                    'label'      => $this->translator->trans('mautic.nameday.segment.nameday.'.$countryEnum->getCountryName()),
                    'properties' => $properties,
                    'operators'  => [
                        'empty' => $this->translator->trans('mautic.nameday.segment.is.today'),
                    ],
                ];
                $event->addChoice('lead', $countryEnum->getTableName(), $options);
            }

        }
    }

    /**
     * @param LeadListFilteringEvent $event
     */
    public function onListFiltersFiltering(LeadListFilteringEvent $event)
    {
        $filter = $event->getDetails();

        foreach (SettingsKeyEnum::getSupportedCountries() as $supportedCountry) {

            $countryEnum = new CountryEnum($supportedCountry);
            if ($filter['field'] === $countryEnum->getTableName()) {
                $qb     = $event->getQueryBuilder();

                $joins = $qb->getQueryPart('join');
                if (!array_key_exists($countryEnum->getTableName(), $joins)) {
                    $currentDay = (new DateTimeHelper())->getDateTime()->format('m-d');
                    $qb->innerJoin('l', MAUTIC_TABLE_PREFIX.$countryEnum->getTableName(),'ndc', 'ndc.day = :day  AND FIND_IN_SET(lower(l.firstname), lower(ndc.names))');
                    $qb->setParameter(':day', $currentDay);
                }
                $qb->andWhere('ndc.id IS NOT NULL');
                $event->setFilteringStatus(true);
            }
        }



    }

}

<?php

/*
 * @copyright   2019 Mautic Contributors. All rights reserved
 * @author      Mautic
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

class FiltersSubscriber extends CommonSubscriber
{

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
            $properties = ['type' => 'bool'];
            $options    = [
                'label'      => $this->translator->trans('mautic.nameday.segment.nameday'),
                'properties' => $properties,
                'operators'  => [
                    'empty' => $this->translator->trans('mautic.nameday.segment.is.nameday'),
                ],
            ];
            $event->addChoice('lead', 'nameday', $options);
        }
    }

    /**
     * @param LeadListFilteringEvent $event
     */
    public function onListFiltersFiltering(LeadListFilteringEvent $event)
    {
        $filter = $event->getDetails();

        if ($filter['field'] === 'nameday') {
            $qb     = $event->getQueryBuilder();

            $joins = $qb->getQueryPart('join');
            if (!array_key_exists('name_day_calendar', $joins)) {
                $currentDay = (new DateTimeHelper())->getDateTime()->format('m-d');
                $qb->innerJoin('l', MAUTIC_TABLE_PREFIX.'name_day_calendar','ndc', 'ndc.day = :day  AND  FIND_IN_SET(l.firstname, ndc.names)');
                $qb->setParameter(':day', $currentDay);
            }
            $event->setFilteringStatus(true);
        }

    }

}

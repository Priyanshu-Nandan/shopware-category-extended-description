<?php

namespace SALAdditionalDescription\Subscriber;

use Shopware\Storefront\Page\Navigation\NavigationPageLoadedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use SALAdditionalDescription\Extension\CustomFieldExtension;
use Shopware\Core\Framework\DataAbstractionLayer\EntityRepository;
use Shopware\Core\Framework\Context;

class CategorySubscriber implements EventSubscriberInterface
{
    private EntityRepository $categoryRepository;

    public function __construct(EntityRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            NavigationPageLoadedEvent::class => 'onNavigationPageLoaded'
        ];
    }

    public function onNavigationPageLoaded(NavigationPageLoadedEvent $event): void
    {
        // Get the navigation page
        $page = $event->getPage();

        // Get the navigation ID
        $navigationId = $page->getNavigationId();
        
        if (!$navigationId) {
            return;
        }

        // Fetch the category using the repository
        $criteria = new \Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria([$navigationId]);
        $criteria->addAssociation('translations');

        $category = $this->categoryRepository->search($criteria, Context::createDefaultContext())->first();

        // Check if the category exists and has custom fields
        if ($category) {
            $customFields = $category->getTranslated()['customFields'] ?? [];

            // Add the custom field as an extension if it exists
            if (isset($customFields['iteck_additional_description'])) {
                $page->addExtension(
                    'iteck_additional_description',
                    new CustomFieldExtension($customFields['iteck_additional_description'])
                );
            }
        }
    }
}

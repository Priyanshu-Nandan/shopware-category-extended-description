<?php

namespace SALAdditionalDescription;

use Shopware\Core\Framework\Plugin;
use Shopware\Core\Framework\Context;
use Shopware\Core\Framework\Plugin\Context\ActivateContext;
use Shopware\Core\Framework\Plugin\Context\UninstallContext;
use Shopware\Core\System\CustomField\CustomFieldTypes;
use Shopware\Core\Defaults;
use Shopware\Core\Framework\DataAbstractionLayer\EntityRepositoryInterface;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Filter\EqualsFilter;

class SALAdditionalDescription extends Plugin
{
    private const CUSTOM_FIELD_SET_NAME = 'iteck_additional_description';

    public function activate(ActivateContext $activateContext): void
    {
        parent::activate($activateContext);

        $context = $activateContext->getContext();

        /** @var EntityRepositoryInterface $customFieldSetRepository */
        $customFieldSetRepository = $this->container->get('custom_field_set.repository');

        $customFieldSetRepository->create([
            [
                'name' => 'iteck_additional_description',
                'config' => [
                    'label' => [
                        'en-GB' => 'Additional Description',
                        'de-DE' => 'Zusätzliche Beschreibung',
                        Defaults::LANGUAGE_SYSTEM => 'Additional Description'
                    ]
                ],
                'relations' => [
                    [
                        'entityName' => 'category'
                    ]
                ],
                'customFields' => [
                    [
                        'name' => 'iteck_additional_description',
                        'type' => CustomFieldTypes::HTML,
                        'config' => [
                            'label' => [
                                'en-GB' => 'Description 2',
                                'de-DE' => 'Beschreibung 2',
                                Defaults::LANGUAGE_SYSTEM => 'Description 2'
                            ],
                            'customFieldPosition' => 1,
                            'componentName' => 'sw-text-editor',
                            'mediaAllowedExtensions' => ['gif', 'jpg', 'jpeg', 'png', 'svg'],
                            'technical_name' => 'iteck_additional_description'
                        ]
                    ]
                ]
            ]
        ], $context);
    }

    public function uninstall(UninstallContext $uninstallContext): void
    {
        parent::uninstall($uninstallContext);

        $context = $uninstallContext->getContext();

        /** @var EntityRepositoryInterface $customFieldSetRepository */
        $customFieldSetRepository = $this->container->get('custom_field_set.repository');

        // Search for the custom field set by name
        $criteria = new Criteria();
        $criteria->addFilter(new EqualsFilter('name', self::CUSTOM_FIELD_SET_NAME));

        $customFieldSetIds = $customFieldSetRepository->searchIds($criteria, $context)->getIds();

        // Delete the custom field set if it exists
        if (!empty($customFieldSetIds)) {
            $customFieldSetRepository->delete(array_map(function ($id) {
                return ['id' => $id];
            }, $customFieldSetIds), $context);
        }
    }
}

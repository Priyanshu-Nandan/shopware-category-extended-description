<?php

namespace SALAdditionalDescription;

use Shopware\Core\Framework\Plugin;
use Doctrine\DBAL\Connection;
use Shopware\Core\Framework\Plugin\Context\ActivateContext;
use Shopware\Core\Framework\Plugin\Context\UninstallContext;
use Shopware\Core\System\CustomField\CustomFieldTypes;
use Shopware\Core\Defaults;
use Shopware\Core\Framework\DataAbstractionLayer\EntityRepositoryInterface;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Filter\EqualsFilter;
use Shopware\Core\Framework\Plugin\Context\DeactivateContext;

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

    public function deactivate(DeactivateContext $deactivateContext): void
    {
        parent::deactivate($deactivateContext);


        $context = $deactivateContext->getContext();

        $connection = $this->container->get(Connection::class);
        $connection->executeStatement('DELETE FROM custom_field WHERE set_id IN (SELECT id FROM custom_field_set WHERE name = :name)', [
            'name' => self::CUSTOM_FIELD_SET_NAME
        ]);



        /** @var EntityRepositoryInterface $customFieldSetRepository */
        $customFieldSetRepository = $this->container->get('custom_field_set.repository');

        $criteria = new Criteria();
        $criteria->addFilter(new EqualsFilter('name', self::CUSTOM_FIELD_SET_NAME));

        $customFieldSetIds = $customFieldSetRepository->searchIds($criteria, $context)->getIds();

        if (!empty($customFieldSetIds)) {
            $customFieldSetRepository->delete(array_map(function ($id) {
                return ['id' => $id];
            }, $customFieldSetIds), $context);
        }

    }

    public function uninstall(UninstallContext $uninstallContext): void
    {
        parent::uninstall($uninstallContext);

        if ($uninstallContext->keepUserData()) {
            return;
        }

        $context = $uninstallContext->getContext();

        $connection = $this->container->get(Connection::class);
        $connection->executeStatement('DELETE FROM custom_field WHERE set_id IN (SELECT id FROM custom_field_set WHERE name = :name)', [
            'name' => self::CUSTOM_FIELD_SET_NAME
        ]);



        /** @var EntityRepositoryInterface $customFieldSetRepository */
        $customFieldSetRepository = $this->container->get('custom_field_set.repository');

        $criteria = new Criteria();
        $criteria->addFilter(new EqualsFilter('name', self::CUSTOM_FIELD_SET_NAME));

        $customFieldSetIds = $customFieldSetRepository->searchIds($criteria, $context)->getIds();

        if (!empty($customFieldSetIds)) {
            $customFieldSetRepository->delete(array_map(function ($id) {
                return ['id' => $id];
            }, $customFieldSetIds), $context);
        }
    }
}

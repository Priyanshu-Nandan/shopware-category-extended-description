<?php

namespace SALAdditionalDescription\Extension;

use Shopware\Core\Framework\Struct\Struct;

class CustomFieldExtension extends Struct
{
    protected string $description;

    public function __construct(string $description)
    {
        $this->description = $description;
    }

    public function getDescription(): string
    {
        return $this->description;
    }
}
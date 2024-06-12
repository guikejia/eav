<?php

declare(strict_types=1);

namespace Guikejia\Eav\Interface\Data;

interface AttributeDataInterface
{
    public function setEntityId($entity_id): void;

    public function aspect(): void;

    public function execution(): bool;
}

<?php

declare(strict_types=1);

namespace Guikejia\Eav\Service;

use Guikejia\Eav\Interface\Model\ShopEntityInterface;

class ShopService extends EavService implements ShopEntityInterface
{
    protected string $ENTITY_CLASS = ShopEntityInterface::class;

}

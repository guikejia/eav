<?php

declare(strict_types=1);

namespace Guikejia\Eav\Model\Trait;

/**
 * @property int $id ID
 * @property string $code 类别标识
 * @property string $entity_table 实体表
 * @property string $entity_id_field 实体主键ID
 * @property string $default_attribute_set_id 默认属性集
 */
trait EntityType
{
    public const PRODUCT_ID = 1;

    public const SHOP_ID = 2;
}

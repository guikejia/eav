<?php

declare(strict_types=1);

namespace Guikejia\Eav\Model;

/**
 * @property int $id ID
 * @property int $group_id 分组ID
 * @property int $attribute_set_id 属性集ID
 * @property int $attribute_id 属性ID
 */
class EntityAttribute extends Model
{
    use \Guikejia\Eav\Model\Trait\EntityType;
}

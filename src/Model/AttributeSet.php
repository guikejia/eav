<?php

declare(strict_types=1);

namespace Guikejia\Eav\Model;

use Carbon\Carbon;

/**
 * @property int $id ID
 * @property string $name 名称
 * @property int $entity_type_id 类别ID
 * @property Carbon $created_at 创建时间
 * @property Carbon $updated_at 更新时间
 * @property string $deleted_at 删除时间
 * @property null|Attribute[] $attribute
 * @property null|EntityType $entity_type
 * @property null|AttributeGroup[] $attribute_groups
 */
class AttributeSet extends Model
{
    use \Guikejia\Eav\Model\Trait\AttributeSet;
}

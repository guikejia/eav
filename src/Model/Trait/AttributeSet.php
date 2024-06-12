<?php

declare(strict_types=1);

namespace Guikejia\Eav\Model\Trait;

use Carbon\Carbon;
use Hyperf\Database\Model\SoftDeletes;
use Guikejia\Eav\Model\Attribute;
use Guikejia\Eav\Model\AttributeGroup;
use Guikejia\Eav\Model\EntityType;

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
trait AttributeSet
{
    use SoftDeletes;

    public function attribute_groups(): \Hyperf\Database\Model\Relations\HasMany
    {
        return $this->hasMany(AttributeGroup::class, 'attribute_set_id', 'id');
    }

    public function attribute(): \Hyperf\Database\Model\Relations\BelongsToMany
    {
        return $this->belongsToMany(Attribute::class, 'entity_attribute', 'attribute_set_id', 'attribute_id');
    }

    public function entity_type(): \Hyperf\Database\Model\Relations\BelongsTo
    {
        return $this->belongsTo(EntityType::class, 'entity_type_id', 'id');
    }
}

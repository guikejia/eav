<?php

declare(strict_types=1);

namespace Guikejia\Eav\Model\Trait;

use Carbon\Carbon;
use Hyperf\Database\Model\SoftDeletes;
use Guikejia\Eav\Model\AttributeSet;
use Guikejia\Eav\Model\Attribute;

/**
 * @property int $id ID
 * @property int $attribute_set_id 属性集ID
 * @property string $code 分组标识
 * @property string $name 分组名称
 * @property int $sort_order 排序
 * @property int $default_id 默认ID
 * @property Carbon $created_at 创建时间
 * @property Carbon $updated_at 更新时间
 * @property string $deleted_at 删除时间
 * @property null|AttributeSet $attribute_set
 * @property null|Attribute[] $attribute
 */
trait AttributeGroup
{
    use SoftDeletes;

    public function attribute(): \Hyperf\Database\Model\Relations\BelongsToMany
    {
        return $this->belongsToMany(Attribute::class, 'entity_attribute', 'group_id', 'attribute_id')->withPivot('attribute_set_id');
    }

    public function attribute_set(): \Hyperf\Database\Model\Relations\BelongsTo
    {
        return $this->belongsTo(AttributeSet::class, 'attribute_set_id', 'id');
    }
}

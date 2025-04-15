<?php

declare(strict_types=1);

namespace Guikejia\Eav\Model\Trait;

use Guikejia\Eav\Model\Attribute;

/**
 * @property int $id ID
 * @property int $attribute_id 属性ID
 * @property string $value 选项值
 * @property string $label 选项标签
 * @property int $sort_order 排序
 */
trait AttributeOption
{
    public function attribute(): \Hyperf\Database\Model\Relations\BelongsTo
    {
        return $this->belongsTo(Attribute::class, 'attribute_id', 'id');
    }
}

<?php

declare(strict_types=1);

namespace Guikejia\Eav\Model;

use Carbon\Carbon;
use Hyperf\Database\Model\SoftDeletes;
use Hyperf\Database\Model\Model;

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
 * @property AttributeSet $attributeSet
 * @property Attribute $attributes
 */
class AttributeGroup extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     */
    protected ?string $table = 'attribute_group';

    /**
     * The attributes that are mass assignable.
     */
    protected array $fillable = ['id', 'attribute_set_id', 'code', 'name', 'sort_order', 'default_id', 'created_at', 'updated_at', 'deleted_at'];

    /**
     * The attributes that should be cast to native types.
     */
    protected array $casts = ['id' => 'integer', 'attribute_set_id' => 'integer', 'sort_order' => 'integer', 'default_id' => 'integer', 'created_at' => 'datetime', 'updated_at' => 'datetime'];

    public function getAttributeModel()
    {
        return $this->belongsToMany(Attribute::class, 'entity_attribute', 'group_id', 'attribute_id')->withPivot('attribute_set_id');
    }

    public function getAttributeSetModel()
    {
        return $this->belongsTo(AttributeSet::class, 'attribute_set_id', 'id');
    }
}
<?php

declare(strict_types=1);

namespace Guikejia\Eav\Model;

use Carbon\Carbon;
use Guikejia\Eav\Interface\Model\AttributeModelInterface;

/**
 * @property int $id ID
 * @property string $name 名称
 * @property string $icon 图标
 * @property string $code 属性标识
 * @property string $default_value 默认值
 * @property int $type 属性类型:0=无,1=整型,2=字符串,3=浮点型,4=时间,5=文本
 * @property int $entity_type_id 类别ID
 * @property Carbon $created_at 创建时间
 * @property Carbon $updated_at 更新时间
 * @property string $deleted_at 删除时间
 * @property null|AttributeGroup[] $attribute_groups
 * @property null|AttributeSet[] $attribute_sets
 * @property null|EntityType $entity_type
 */
class Attribute extends EavModel implements AttributeModelInterface
{
    use \Guikejia\Eav\Model\Trait\Attribute;

    /**
     * The table associated with the model.
     */
    protected ?string $table = 'attributes';

    /**
     * The attributes that are mass assignable.
     */
    protected array $fillable = ['id', 'name', 'icon', 'code', 'default_value', 'type', 'entity_type_id', 'created_at', 'updated_at', 'deleted_at'];

    /**
     * The attributes that should be cast to native types.
     */
    protected array $casts = ['id' => 'integer', 'type' => 'integer', 'entity_type_id' => 'integer', 'created_at' => 'datetime', 'updated_at' => 'datetime'];
}

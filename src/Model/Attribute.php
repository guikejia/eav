<?php

declare(strict_types=1);

namespace Guikejia\Eav\Model;

use Carbon\Carbon;
use Hyperf\Database\Model\SoftDeletes;

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
class Attribute extends Model
{
    use SoftDeletes;

    public const TYPE_INT = 1;

    public const TYPE_STRING = 2;

    public const TYPE_FLOAT = 3;

    public const TYPE_TIME = 4;

    public const TYPE_TEXT = 5;

    protected int $entity_id;

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

    public function setEntityAttributeValue($entity_id, $value): bool
    {
        $attributes = [
            'attribute_id' => $this->id,
            'entity_id' => $entity_id,
        ];

        $value = [
            'attribute_id' => $this->id,
            'entity_id' => $entity_id,
            'value' => $value,
        ];

        $data = match ($this->type) {
            Attribute::TYPE_INT => AttributeValueInt::updateOrCreate($attributes, $value),
            Attribute::TYPE_FLOAT => AttributeValueDecimal::updateOrCreate($attributes, $value),
            Attribute::TYPE_TIME => AttributeValueDatetime::updateOrCreate($attributes, $value),
            Attribute::TYPE_TEXT => AttributeValueText::updateOrCreate($attributes, $value),
            default => AttributeValueVarchar::updateOrCreate($attributes, $value),
        };

        return (int) $data?->id > 0;
    }

    public function getEntityAttributeValue($entity_id = null)
    {
        $conditions = [
            'attribute_id' => $this->id,
            'entity_id' => $entity_id ?? $this->entity_id,
        ];

        $value = match ($this->type) {
            Attribute::TYPE_INT => AttributeValueInt::query()->where($conditions)->value('value'),
            Attribute::TYPE_FLOAT => AttributeValueDecimal::query()->where($conditions)->value('value'),
            Attribute::TYPE_TIME => AttributeValueDatetime::query()->where($conditions)->value('value'),
            Attribute::TYPE_TEXT => AttributeValueText::query()->where($conditions)->value('value'),
            default => AttributeValueVarchar::query()->where($conditions)->value('value'),
        };

        if (empty($value) && !empty($this->default_value)) {
            $value = $this->default_value;
        }

        return $value;
    }

    public function setEntityId($entity_id): void
    {
        $this->entity_id = $entity_id;
    }

    public function attribute_groups(): \Hyperf\Database\Model\Relations\BelongsToMany
    {
        return $this->belongsToMany(AttributeGroup::class, 'entity_attribute', 'attribute_id', 'group_id');
    }

    public function attribute_sets(): \Hyperf\Database\Model\Relations\BelongsToMany
    {
        return $this->belongsToMany(AttributeSet::class, 'entity_attribute', 'attribute_id', 'attribute_set_id');
    }

    public function entity_type(): \Hyperf\Database\Model\Relations\BelongsTo
    {
        return $this->belongsTo(EntityType::class, 'entity_type_id', 'id');
    }
}

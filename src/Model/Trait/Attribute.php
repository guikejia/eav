<?php

declare(strict_types=1);

namespace Guikejia\Eav\Model\Trait;

use Carbon\Carbon;
use Guikejia\Eav\Interface\Model\AttributeValueDatetimeInterface;
use Guikejia\Eav\Interface\Model\AttributeValueDecimalInterface;
use Guikejia\Eav\Interface\Model\AttributeValueIntInterface;
use Guikejia\Eav\Interface\Model\AttributeValueTextInterface;
use Guikejia\Eav\Interface\Model\AttributeValueVarcharInterface;
use Hyperf\Database\Model\SoftDeletes;
use Guikejia\Eav\Model\AttributeValueInt;
use Guikejia\Eav\Model\AttributeValueDecimal;
use Guikejia\Eav\Model\AttributeValueDatetime;
use Guikejia\Eav\Model\AttributeValueVarchar;
use Guikejia\Eav\Model\AttributeValueText;
use Guikejia\Eav\Model\EntityType;
use Guikejia\Eav\Model\AttributeGroup;
use Guikejia\Eav\Model\AttributeSet;
use function Hyperf\Support\make;

/**
 * @property int $id ID
 * @property string $name 名称
 * @property string $icon 图标
 * @property string $code 属性标识
 * @property string $default_value 默认值
 * @property int $type 属性类型:0=无,1=整型,2=字符串,3=浮点型,4=时间,5=文本
 * @property int $entity_type_id 类别ID
 * @property string $value_type 前台组件类型
 * @property string $backend_component 后台组件类型
 * @property string $source_model 组件数据源
 * @property Carbon $created_at 创建时间
 * @property Carbon $updated_at 更新时间
 * @property string $deleted_at 删除时间
 * @property null|AttributeGroup[] $attribute_groups
 * @property null|AttributeSet[] $attribute_sets
 * @property null|EntityType $entity_type
 * @property AttributeValueInt $attributeValueInt
 * @property AttributeValueDecimal $attributeValueDecimal
 * @property AttributeValueDatetime $attributeValueDatetime
 * @property AttributeValueText $attributeValueText
 * @property AttributeValueVarchar $attributeValueVarchar
 */
trait Attribute
{
    use SoftDeletes;

    public const TYPE_INT = 1;

    public const TYPE_STRING = 2;

    public const TYPE_FLOAT = 3;

    public const TYPE_TIME = 4;

    public const TYPE_TEXT = 5;

    public const COMPONENT_LIST = [
        self::COMPONENT_TEXT => '文本',
        self::COMPONENT_IMAGE => '图片',
        self::COMPONENT_MULTI_IMAGE => '多图',
        self::COMPONENT_RICH_TEXT => '富文本',
        self::COMPONENT_TAG => '标签',
        self::COMPONENT_SELECT => '下拉单选',
        self::COMPONENT_MULTI_SELECT => '下拉多选',
        self::COMPONENT_RADIO => '单选',
        self::COMPONENT_DATE => '日期',
        self::COMPONENT_DATE_RANGE => '日期范围',
        self::COMPONENT_DATETIME => '日期时间',
        self::COMPONENT_DATETIME_RANGE => '日期时间范围',
        self::COMPONENT_TIME => '时间',
        self::COMPONENT_TIME_RANGE => '时间范围',
    ];

    public const COMPONENT_TEXT = 'text';

    public const COMPONENT_IMAGE = 'image';

    public const COMPONENT_MULTI_IMAGE = 'multi_images';

    public const COMPONENT_RICH_TEXT = 'rich_text';

    public const COMPONENT_TAG = 'tag';

    public const COMPONENT_SELECT = 'select';

    public const COMPONENT_MULTI_SELECT = 'multi_select';

    public const COMPONENT_RADIO = 'radio';

    public const COMPONENT_DATE = 'date';

    public const COMPONENT_DATE_RANGE = 'date_range';

    public const COMPONENT_DATETIME = 'datetime';

    public const COMPONENT_DATETIME_RANGE = 'datetime_range';

    public const COMPONENT_TIME = 'time';

    public const COMPONENT_TIME_RANGE = 'time_range';

    protected int $entity_id;

    public function setEntityAttributeValue($entity_id, $value): bool
    {
        $attributes = [
            'attribute_id' => $this->id,
            'entity_id' => $entity_id,
        ];

        $value = [
            'attribute_id' => $this->id,
            'entity_id' => $entity_id,
            'entity_type_id' => $this->entity_type_id ?? 0,
            'value' => $value,
        ];

        $data = match ($this->type) {
            self::TYPE_INT => make(AttributeValueIntInterface::class)->updateOrCreate($attributes, $value),
            self::TYPE_FLOAT => make(AttributeValueDecimalInterface::class)->updateOrCreate($attributes, $value),
            self::TYPE_TIME => make(AttributeValueDatetimeInterface::class)->updateOrCreate($attributes, $value),
            self::TYPE_TEXT => make(AttributeValueTextInterface::class)->updateOrCreate($attributes, $value),
            default => make(AttributeValueVarcharInterface::class)->updateOrCreate($attributes, $value),
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
            self::TYPE_INT => make(AttributeValueIntInterface::class)->where($conditions)->value('value'),
            self::TYPE_FLOAT => make(AttributeValueDecimalInterface::class)->where($conditions)->value('value'),
            self::TYPE_TIME => make(AttributeValueDatetimeInterface::class)->where($conditions)->value('value'),
            self::TYPE_TEXT => make(AttributeValueTextInterface::class)->where($conditions)->value('value'),
            default => make(AttributeValueVarcharInterface::class)->where($conditions)->value('value'),
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

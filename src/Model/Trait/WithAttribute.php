<?php

declare(strict_types=1);

namespace Guikejia\Eav\Model\Trait;

use Guikejia\Eav\Interface\Model\AttributeGroupInterface;
use Guikejia\Eav\Interface\Model\AttributeInterface;
use Guikejia\Eav\Interface\Model\EntityAttributeInterface;
use Guikejia\Eav\Model\EntityType;
use Guikejia\Eav\Model\Attribute;
use Guikejia\Eav\Model\AttributeSet;
use Guikejia\Eav\Attribute\RefundWithoutVerifyAttributeData;
use Guikejia\Eav\Exception\InvalidEntityAttributeException;
use Hyperf\Database\Model\Model;
use Hyperf\Database\Model\Relations\BelongsTo;

use function Hyperf\Support\make;

trait WithAttribute
{
    public const ATTRIBUTE_CLASS = [
        'refund_without_verify' => RefundWithoutVerifyAttributeData::class
    ];

    /**
     * 获取实体类型
     * @return EntityType|null
     */
    public function getEntityType(): ?EntityType
    {
        /**
         * @var AttributeSet $attribute_set
         * @var EntityType $entity_type
         */
        $attribute_set = $this->attribute_set()->first();
        $entity_type = $attribute_set?->entity_type()->first();

        if ($entity_type) {
            return $entity_type;
        }

        return null;
    }

    /**
     * 判断实体类型与当前实体是否匹配
     * @return bool
     */
    public function isEntityType(): bool
    {
        if ($entity_type = $this->getEntityType()) {
            return $entity_type->entity_table === $this->getTable();
        }

        return false;
    }

    /**
     * 获取所有实体属性的值
     */
    public function getEntityAttributes()
    {
        if ($this->isEntityType() === false) {
            throw new InvalidEntityAttributeException('当前实体与实体类型不匹配');
        }

        $attribute_set = $this->attribute_set()->first();
        /**
         * @var AttributeSet $attribute_set
         */
        return $attribute_set?->attribute()->get();
    }

    /**
     * 获取所有实体属性的值
     * @return array
     */
    public function getEntityAttributeValues(): array
    {
        $attributes = $this->getEntityAttributes();

        $values = [];
        /**
         * @var Attribute $attribute
         */
        foreach ($attributes as $attribute) {
            $values[$attribute->code] = $attribute?->getEntityAttributeValue($this->getKey());
        }

        return $values;
    }

    public function getBackendEntityAttributes(): array
    {
        $attributes = $this->getEntityAttributes();

        $values = [];
        /**
         * @var Attribute $attribute
         */
        foreach ($attributes as $attribute) {
            $backend_component = $attribute->backend_component;
            $value = $attribute?->getEntityAttributeValue($this->getKey());

            $values[$attribute->code] = $value ? $this->getBackendEntityValue($backend_component, $value) : $value;
        }

        return $values;
    }

    public function transBackendEntityValue($component, $value)
    {
        return match ($component) {
            Attribute::COMPONENT_TIME_RANGE, Attribute::COMPONENT_DATETIME_RANGE, Attribute::COMPONENT_DATE_RANGE => json_encode($value),
            Attribute::COMPONENT_TAG, Attribute::COMPONENT_MULTI_IMAGE, Attribute::COMPONENT_MULTI_SELECT, Attribute::COMPONENT_CHECKBOX => implode(',', $value),
            default => $value,
        };
    }

    public function getBackendEntityValue($component, $value)
    {
        return match ($component) {
            Attribute::COMPONENT_TIME_RANGE, Attribute::COMPONENT_DATETIME_RANGE, Attribute::COMPONENT_DATE_RANGE => json_decode($value, true),
            Attribute::COMPONENT_TAG, Attribute::COMPONENT_MULTI_IMAGE, Attribute::COMPONENT_MULTI_SELECT, Attribute::COMPONENT_CHECKBOX => explode(',', $value),
            default => $value,
        };
    }

    /**
     * 获取某个实体属性的值
     */
    public function getEntityAttribute(string $attribute_code)
    {
        if ($this->isEntityType() === false) {
            throw new InvalidEntityAttributeException('当前实体与实体类型不匹配');
        }

        /**
         * @var Attribute $attribute
         */
        if (in_array($attribute_code, array_keys(self::ATTRIBUTE_CLASS))) {
            $attribute = self::ATTRIBUTE_CLASS[$attribute_code]::where('code', $attribute_code)->first();
        } else {
            $attribute = make(AttributeInterface::class)->where('code', $attribute_code)->first();
        }

        if (!$attribute) {
            throw new InvalidEntityAttributeException('Attribute not found: ' . $attribute_code);
        }

        $attribute->setEntityId($this->getKey());

        return $attribute;
    }

    public function getEntityAttributeValue(string $attribute_code)
    {
        /**
         * @var Attribute $attribute
         */
        if ($attribute = $this->getEntityAttribute($attribute_code)) {
            return $attribute->getEntityAttributeValue($this->getKey());
        }

        return null;
    }

    /**
     * 设置实体属性的值
     * @param string $attribute_code
     * @param mixed $value
     * @return bool|null
     */
    public function setEntityAttribute(string $attribute_code, mixed $value): ?bool
    {
        if ($this->isEntityType() === false) {
            throw new InvalidEntityAttributeException('当前实体与实体类型不匹配');
        }

        $attribute = make(AttributeInterface::class)->where('code', $attribute_code)->first();

        if ($attribute) {
            $value = $this->transBackendEntityValue($attribute->backend_component, $value);
            return $attribute->setEntityAttributeValue($this->getKey(), $value);
        }

        throw new InvalidEntityAttributeException('Attribute not found: ' . $attribute_code);
    }

    /**
     * 获取商品的属性分组.
     * @return \Guikejia\Eav\Model\AttributeGroup[]
     */
    public function getAttributeGroup()
    {
        return make(AttributeGroupInterface::class)
            ->where('attribute_set_id', $this->attribute_set_id)
            ->get();
    }

    /**
     * 获取属性值(包含实体属性)
     */
    public function getAttribute(string $key)
    {
        if ($attribute = parent::getAttribute($key)) {
            return $attribute;
        }

        if ($this->hasEavAttribute($key)) {
            return $this->getEntityAttributeValue($key);
        }
    }

    /**
     * 设置属性值(包含实体属性)
     * @param string $key
     * @param mixed $value
     * @return Model
     */
    public function setAttribute(string $key, mixed $value)
    {
        if ($this->getAttribute($key)) {
            return parent::setAttribute($key, $value);
        }

        if ($this->hasEavAttribute($key)) {
            $this->setEntityAttribute($key, $value);
        }

        return $this;
    }

    public function isHasAppended(string $attribute): bool
    {
        if (method_exists($this, 'hasAppended')) {
            return $this->hasAppended($attribute);
        }

        return false;
    }

    /**
     * 获取实体属性的IDs
     * @return array
     */
    public function getEntityAttributeIds(): array
    {
        $attribute_set_id = $this->attribute_set_id;

        if (! $attribute_set_id) {
            return [];
        }

        return make(EntityAttributeInterface::class)
            ->where('attribute_set_id', $attribute_set_id)
            ->pluck('attribute_id')
            ->toArray();
    }

    /**
     * 获取包含实体属性在哪的所有属性值
     * @return array
     */
    public function getAttributesWithEntity(): array
    {
        $entity_attributes = $this->getEntityAttributeValues();
        $attributes = parent::getAttributes();

        return array_merge($attributes, $entity_attributes);
    }

    /**
     * 属性集模型关系
     * @return BelongsTo
     */
    public function attribute_set(): BelongsTo
    {
        return $this->belongsTo(AttributeSet::class, 'attribute_set_id', 'id');
    }

    public function attributes(): \Hyperf\Collection\Enumerable|\Hyperf\Collection\Collection
    {
        return $this->attribute_set()->with('attribute')->get()->pluck('attribute')->flatten();
    }

    public function hasEavAttribute(string $attribute): bool
    {
        return $this->attribute_set()->whereRelation('attribute', 'code', $attribute)->exists();
    }
}

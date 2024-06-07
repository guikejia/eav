<?php

declare(strict_types=1);

namespace Guikejia\Eav\Model;

use Guikejia\Eav\Attribute\RefundWithoutVerifyAttribute;
use Guikejia\Eav\Exception\InvalidEntityAttributeException;
use Hyperf\Database\Model\Relations\BelongsTo;
use Hyperf\Stringable\Str;

abstract class WithAttribute extends Model
{
    public const ATTRIBUTE_CLASS = [
        'refund_without_verify' => RefundWithoutVerifyAttribute::class
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
     * @return array
     */
    public function getEntityAttributes(): array
    {
        if ($this->isEntityType() === false) {
            throw new InvalidEntityAttributeException('当前实体与实体类型不匹配');
        }

        $attribute_set = $this->attribute_set()->first();
        /**
         * @var AttributeSet $attribute_set
         */
        $attributes = $attribute_set?->attribute()->get();

        $values = [];
        /**
         * @var Attribute $attribute
         */
        foreach ($attributes as $attribute) {
            $values[$attribute->code] = $attribute?->getEntityAttributeValue($this->getKey());
        }

        return $values;
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
            $attribute = Attribute::query()->where('code', $attribute_code)->first();
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

        $attribute = Attribute::query()->where('code', $attribute_code)->first();

        if ($attribute) {
            return $attribute->setEntityAttributeValue($this->getKey(), $value);
        }

        throw new InvalidEntityAttributeException('Attribute not found: ' . $attribute_code);
    }

    public function getAttributeGroup()
    {
        /**
         * @var AttributeSet $attribute_set
         * @var AttributeGroup $attribute_group
         */
        $attribute_set = $this->attribute_set()->first();
        return $attribute_set->attribute_groups()->get();
    }

    /**
     * 获取属性值(包含实体属性)
     */
    public function getAttribute(string $key)
    {
        if ($this->hasSetMutator($key) ||
            $this->hasCast($key) ||
            $this->isDateAttribute($key) ||
            Str::contains($key, '->')) {
            return parent::getAttribute($key);
        } else {
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
        if ($this->hasSetMutator($key) ||
            $this->hasCast($key) ||
            $this->isDateAttribute($key) ||
            Str::contains($key, '->')) {
            return parent::setAttribute($key, $value);
        } else {
            $this->setEntityAttribute($key, $value);
        }

        return $this;
    }

    /**
     * 获取实体属性的IDs
     * @return array
     */
    public function getEntityAttributeIds(): array
    {
        $attribute_set_id = $this->getAttribute('attribute_set_id');

        if (! $attribute_set_id) {
            return [];
        }

        return EntityAttribute::query()
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
        $entity_attributes = $this->getEntityAttributes();
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
}

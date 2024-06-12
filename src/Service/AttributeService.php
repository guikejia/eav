<?php

declare(strict_types=1);

namespace Guikejia\Eav\Service;

use Guikejia\Eav\Interface\Model\AttributeInterface;
use Guikejia\Eav\Interface\Model\EntityAttributeInterface;
use Guikejia\Eav\Model\Attribute;
use Guikejia\Eav\Model\EntityAttribute;
use Hyperf\Collection\Collection;
use function Hyperf\Support\make;

class AttributeService
{
    public function getGroupAttributes($group_id, $entity_id = null): array
    {
        return $this->getAttributeByIds($this->getGroupAttributeIds($group_id), $entity_id);
    }

    public function getAttributeByIds(array $ids, $entity_id = null): array
    {
        /**
         * @var Attribute $attribute
         */
        $attribute = make(AttributeInterface::class);
        /**
         * @var Attribute[]|Collection $attributes
         */
        $collection = $attribute->whereIn('id', $ids)->get([
            'id',
            'code',
            'name',
            'icon',
            'type',
            'value_type',
        ]);

        $attributes = [];
        foreach ($collection as $attribute) {
            $attributes[$attribute->code] = [
                'id' => $attribute->id,
                'code' => $attribute->code,
                'name' => $attribute->name,
                'icon' => $attribute->icon,
                'type' => $attribute->type,
                'value_type' => $attribute->value_type,
                'value' => $attribute->getEntityAttributeValue($entity_id),
            ];
        }

        return $attributes;
    }

    /**
     * 获取属性集中没有分组的属性IDs.
     * @param $attribute_set_id
     * @return array
     */
    public function getNonGroupAttributeIds($attribute_set_id): array
    {
        /**
         * @var $entity_attribute EntityAttribute
         */
        $entity_attribute = make(EntityAttributeInterface::class);
        return $entity_attribute
            ->where('attribute_set_id', $attribute_set_id)
            ->where(function ($query) {
                $query->where('group_id', 0)
                    ->orWhereNull('group_id');
            })
            ->pluck('attribute_id')
            ->toArray();
    }

    public function getGroupAttributeIds($group_id): array
    {
        /**
         * @var $entity_attribute EntityAttribute
         */
        $entity_attribute = make(EntityAttributeInterface::class);
        return $entity_attribute
            ->where('group_id', $group_id)
            ->pluck('attribute_id')
            ->toArray();
    }

    public function getSetAttributeIds($attribute_set_id): array
    {
        /**
         * @var $entity_attribute EntityAttribute
         */
        $entity_attribute = make(EntityAttributeInterface::class);
        return $entity_attribute
            ->where('attribute_set_id', $attribute_set_id)
            ->pluck('attribute_id')
            ->toArray();
    }
}

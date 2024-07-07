<?php

declare(strict_types=1);

namespace Guikejia\Eav\Service;

use Guikejia\Eav\Exception\InvalidEntityAttributeException;
use Guikejia\Eav\Interface\Model\ProductEntityInterface;

use function Hyperf\Support\make;

class EavService
{
    public function __construct(
        protected AttributeService $attributeService,
    ) {
    }

    // 默认值，可在实体类中根据实际情况修改
    protected string $ENTITY_CLASS = ProductEntityInterface::class;

    /**
     * 获取实体属性（包含完整的分组与属性结构）
     * @param int $entity_id
     * @return array
     */
    public function getEavAttributes(int $entity_id): array
    {
        $entity = $this->getEntity($entity_id);
        $attribute_groups = $entity->getAttributeGroup();

        $groups = [];
        foreach ($attribute_groups as $attribute_group) {
            $groups[] = [
                'id' => $attribute_group->id,
                'code' => $attribute_group->code,
                'name' => $attribute_group->name,
                'attributes' => $this->attributeService->getGroupAttributes($attribute_group->id, $entity_id),
            ];
        }

        $attribute_ids = $this->attributeService->getNonGroupAttributeIds($entity->attribute_set_id);
        $attributes = $this->attributeService->getAttributeByIds($attribute_ids, $entity_id);

        return ['groups' => $groups, 'attributes' => $attributes];
    }

    public function getEntity($entity_id)
    {
        $entity = make($this->ENTITY_CLASS)->whereKey($entity_id)->first();

        if (!$entity) {
            throw new InvalidEntityAttributeException('Entity not fount: ' . $entity_id);
        }

        return $entity;
    }
}

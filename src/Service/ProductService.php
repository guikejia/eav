<?php

declare(strict_types=1);

namespace Guikejia\Eav\Service;

use Guikejia\Eav\Attribute\RefundWithoutVerifyAttribute;
use Guikejia\Eav\Exception\InvalidProductException;
use Guikejia\Eav\Model\AttributeGroup;
use Guikejia\Eav\Model\ProductEntity;

class ProductService
{
    public function getProductAttributes($product_id): array
    {
        $product = $this->getProduct($product_id);

        $attributes = $product->getEntityAttributes();
        $attribute_groups = $product->getAttributeGroup();

        /**
         * @var AttributeGroup $attribute_group
         */
        $groups = [];
        foreach ($attribute_groups as $attribute_group) {
            $attribute = $attribute_group->attribute()->first();
            $code = $attribute?->getAttribute('code');

            if ($attribute && in_array($code, array_keys($attributes))) {
                $groups[$attribute_group->code] = $attribute->toArray();
            }
        }

        return $groups;
    }

    public function isProductRefundVerify($product_id): bool
    {
        $product = $this->getProduct($product_id);

        /**
         * @var RefundWithoutVerifyAttribute $refund_without_verify
         */
        if ($refund_without_verify = $product->getEntityAttribute('refund_without_verify')) {
            return $refund_without_verify->execution();
        }

        return true;
    }

    public function getProduct($id): ProductEntity
    {
        /**
         * @var ?ProductEntity $product
         */
        $product = ProductEntity::query()->whereKey($id)->first();

        if (!$product) {
            throw new InvalidProductException('Product not found: ' . $id);
        }

        return $product;
    }
}

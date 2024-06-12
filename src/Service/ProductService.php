<?php

declare(strict_types=1);

namespace Guikejia\Eav\Service;

use Guikejia\Eav\Attribute\RefundWithoutVerifyAttributeData;
use Guikejia\Eav\Exception\InvalidProductException;
use Guikejia\Eav\Interface\Model\ProductEntityInterface;
use Guikejia\Eav\Model\ProductEntity;
use function Hyperf\Support\make;

class ProductService
{
    public function __construct(
        protected AttributeService $attributeService,
    ) {
    }

    /**
     * 获取商品属性（包含完整的分组与属性结构）
     * @param $product_id
     * @return array
     */
    public function getProductAttributes($product_id): array
    {
        $product = $this->getProduct($product_id);
        $attribute_groups = $product->getAttributeGroup();

        $groups = [];
        foreach ($attribute_groups as $attribute_group) {
            $groups[$attribute_group->code] =
                $this->attributeService->getGroupAttributes($attribute_group->id, $product_id);
        }

        $attribute_ids = $this->attributeService->getNonGroupAttributeIds($product->attribute_set_id);
        $attributes = $this->attributeService->getAttributeByIds($attribute_ids, $product_id);

        return ['groups' => $groups, 'attributes' => $attributes];
    }

    public function isProductRefundVerify($product_id): bool
    {
        $product = $this->getProduct($product_id);

        /**
         * @var RefundWithoutVerifyAttributeData $refund_without_verify
         */
        if ($refund_without_verify = $product->getEntityAttribute('refund_without_verify')) {
            return $refund_without_verify->execution();
        }

        return true;
    }

    public function getProduct($id): ProductEntityInterface
    {
        /**
         * @var ?ProductEntity $product
         */
        $product = make(ProductEntityInterface::class)->whereKey($id)->first();

        if (!$product) {
            throw new InvalidProductException('Product not found: ' . $id);
        }

        return $product;
    }
}

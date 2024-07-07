<?php

declare(strict_types=1);

namespace Guikejia\Eav\Service;

use Guikejia\Eav\Attribute\RefundWithoutVerifyAttributeData;
use Guikejia\Eav\Interface\Model\ProductEntityInterface;

class ProductService extends EavService
{
    public const ENTITY_CLASS = ProductEntityInterface::class;

    public function isProductRefundVerify($product_id): bool
    {
        $product = $this->getEntity($product_id);

        /**
         * @var RefundWithoutVerifyAttributeData $refund_without_verify
         */
        if ($refund_without_verify = $product->getEntityAttribute('refund_without_verify')) {
            return $refund_without_verify->execution();
        }

        return true;
    }
}

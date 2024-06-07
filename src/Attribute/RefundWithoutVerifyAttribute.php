<?php

declare(strict_types=1);

namespace Guikejia\Eav\Attribute;

use Guikejia\Eav\Interface\AttributeInterface;
use Guikejia\Eav\Model\Attribute;

class RefundWithoutVerifyAttribute extends Attribute implements AttributeInterface
{
    protected string $code = 'refund_without_verify';

    protected int $type = Attribute::TYPE_INT;

    protected const REFUND_WITHOUT_VERIFY = 1;

    protected const REFUND_WITH_VERIFY = 0;

    public function aspect(): void
    {
    }

    public function execution(): bool
    {
        if ($this->getEntityAttributeValue($this->entity_id) === self::REFUND_WITHOUT_VERIFY) {
            return false;
        }

        return true;
    }
}

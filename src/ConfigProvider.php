<?php

declare(strict_types=1);

namespace Guikejia\Eav;

use Guikejia\Eav\Interface\Model\AttributeGroupInterface;
use Guikejia\Eav\Interface\Model\AttributeInterface;
use Guikejia\Eav\Interface\Model\AttributeOptionInterface;
use Guikejia\Eav\Interface\Model\AttributeSetInterface;
use Guikejia\Eav\Interface\Model\AttributeValueDatetimeInterface;
use Guikejia\Eav\Interface\Model\AttributeValueDecimalInterface;
use Guikejia\Eav\Interface\Model\AttributeValueIntInterface;
use Guikejia\Eav\Interface\Model\AttributeValueTextInterface;
use Guikejia\Eav\Interface\Model\AttributeValueVarcharInterface;
use Guikejia\Eav\Interface\Model\EntityAttributeInterface;
use Guikejia\Eav\Interface\Model\EntityTypeInterface;
use Guikejia\Eav\Interface\Model\ProductEntityInterface;
use Guikejia\Eav\Model\Attribute;
use Guikejia\Eav\Model\AttributeGroup;
use Guikejia\Eav\Model\AttributeOption;
use Guikejia\Eav\Model\AttributeSet;
use Guikejia\Eav\Model\AttributeValueDatetime;
use Guikejia\Eav\Model\AttributeValueDecimal;
use Guikejia\Eav\Model\AttributeValueInt;
use Guikejia\Eav\Model\AttributeValueText;
use Guikejia\Eav\Model\AttributeValueVarchar;
use Guikejia\Eav\Model\EntityAttribute;
use Guikejia\Eav\Model\EntityType;
use Guikejia\Eav\Model\ProductEntity;

class ConfigProvider
{
    public function __invoke(): array
    {
        return [
            'dependencies' => [
                EntityTypeInterface::class => EntityType::class,
                EntityAttributeInterface::class => EntityAttribute::class,
                AttributeInterface::class => Attribute::class,
                AttributeOptionInterface::class => AttributeOption::class,
                AttributeGroupInterface::class => AttributeGroup::class,
                AttributeSetInterface::class => AttributeSet::class,
                AttributeValueIntInterface::class => AttributeValueInt::class,
                AttributeValueDecimalInterface::class => AttributeValueDecimal::class,
                AttributeValueDatetimeInterface::class => AttributeValueDatetime::class,
                AttributeValueTextInterface::class => AttributeValueText::class,
                AttributeValueVarcharInterface::class => AttributeValueVarchar::class,
                ProductEntityInterface::class => ProductEntity::class,
            ],
            'commands' => [
            ],
            'annotations' => [
                'scan' => [
                    'paths' => [
                        __DIR__,
                    ],
                ],
            ],
        ];
    }
}

<?php

declare(strict_types=1);

namespace Guikejia\Eav;

use Guikejia\Eav\Interface\Model\AttributeGroupModelInterface;
use Guikejia\Eav\Interface\Model\AttributeModelInterface;
use Guikejia\Eav\Interface\Model\AttributeSetModelInterface;
use Guikejia\Eav\Interface\Model\AttributeValueDatetimeModelInterface;
use Guikejia\Eav\Interface\Model\AttributeValueDecimalModelInterface;
use Guikejia\Eav\Interface\Model\AttributeValueIntModelInterface;
use Guikejia\Eav\Interface\Model\AttributeValueTextModelInterface;
use Guikejia\Eav\Interface\Model\AttributeValueVarcharModelInterface;
use Guikejia\Eav\Interface\Model\EntityAttributeModelInterface;
use Guikejia\Eav\Interface\Model\EntityTypeModelInterface;
use Guikejia\Eav\Interface\Model\ProductEntityModelInterface;
use Guikejia\Eav\Model\Attribute;
use Guikejia\Eav\Model\AttributeGroup;
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
                EntityTypeModelInterface::class => EntityType::class,
                EntityAttributeModelInterface::class => EntityAttribute::class,
                AttributeModelInterface::class => Attribute::class,
                AttributeGroupModelInterface::class => AttributeGroup::class,
                AttributeSetModelInterface::class => AttributeSet::class,
                AttributeValueIntModelInterface::class => AttributeValueInt::class,
                AttributeValueDecimalModelInterface::class => AttributeValueDecimal::class,
                AttributeValueDatetimeModelInterface::class => AttributeValueDatetime::class,
                AttributeValueTextModelInterface::class => AttributeValueText::class,
                AttributeValueVarcharModelInterface::class => AttributeValueVarchar::class,
                ProductEntityModelInterface::class => ProductEntity::class,
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

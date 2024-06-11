<?php

declare(strict_types=1);

namespace Guikejia\Eav\Model;

/**
 * @property int $id 
 * @property int $entity_type_id 
 * @property int $entity_id 
 * @property int $attribute_id 
 * @property string $value 
 */
class AttributeValueText extends Model
{
    use \Guikejia\Eav\Model\Trait\AttributeValueText;
}

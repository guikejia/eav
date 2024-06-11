<?php

declare(strict_types=1);

namespace Guikejia\Eav\Model;

use Carbon\Carbon;

/**
 * @property int $id 
 * @property int $entity_type_id 
 * @property int $entity_id 
 * @property int $attribute_id 
 * @property Carbon $value
 */
class AttributeValueDatetime extends Model
{
    use \Guikejia\Eav\Model\Trait\AttributeValueDatetime;
}

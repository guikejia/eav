<?php

declare(strict_types=1);

namespace Guikejia\Eav\Model;

use Carbon\Carbon;
use Guikejia\Eav\Interface\Model\AttributeValueDatetimeInterface;

/**
 * @property int $id 
 * @property int $entity_type_id 
 * @property int $entity_id 
 * @property int $attribute_id 
 * @property Carbon $value
 */
class AttributeValueDatetime extends EavModel implements AttributeValueDatetimeInterface
{
    use \Guikejia\Eav\Model\Trait\AttributeValueDatetime;

    public bool $timestamps = false;

    /**
     * The table associated with the model.
     */
    protected ?string $table = 'attribute_value_datetime';

    /**
     * The attributes that are mass assignable.
     */
    protected array $fillable = ['id', 'entity_type_id', 'entity_id', 'attribute_id', 'value'];

    /**
     * The attributes that should be cast to native types.
     */
    protected array $casts = ['id' => 'integer', 'entity_type_id' => 'integer', 'entity_id' => 'integer', 'attribute_id' => 'integer'];
}

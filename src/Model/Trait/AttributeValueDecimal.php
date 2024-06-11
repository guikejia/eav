<?php

declare(strict_types=1);

namespace Guikejia\Eav\Model\Trait;

/**
 * @property int $id 
 * @property int $entity_type_id 
 * @property int $entity_id 
 * @property int $attribute_id 
 * @property float $value
 */
trait AttributeValueDecimal
{
    public bool $timestamps = false;
    /**
     * The table associated with the model.
     */
    protected ?string $table = 'attribute_value_decimal';

    /**
     * The attributes that are mass assignable.
     */
    protected array $fillable = ['id', 'entity_type_id', 'entity_id', 'attribute_id', 'value'];

    /**
     * The attributes that should be cast to native types.
     */
    protected array $casts = ['id' => 'integer', 'entity_type_id' => 'integer', 'entity_id' => 'integer', 'attribute_id' => 'integer', 'value' => 'decimal:2'];
}

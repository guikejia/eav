<?php

declare(strict_types=1);

namespace Guikejia\Eav\Model;

use Guikejia\Eav\Interface\Model\AttributeOptionInterface;

class AttributeOption extends EavModel implements AttributeOptionInterface
{
    use \Guikejia\Eav\Model\Trait\AttributeOption;

    public bool $timestamps = false;

    /**
     * The table associated with the model.
     */
    protected ?string $table = 'attribute_options';

    /**
     * The attributes that are mass assignable.
     */
    protected array $fillable = ['id', 'attribute_id', 'value', 'label', 'sort_order'];

    /**
     * The attributes that should be cast to native types.
     */
    protected array $casts = ['id' => 'integer', 'sort_order' => 'integer', 'attribute_id' => 'integer'];
}

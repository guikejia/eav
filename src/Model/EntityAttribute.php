<?php

declare(strict_types=1);

namespace Guikejia\Eav\Model;

use Hyperf\Database\Model\Model;

/**
 * @property int $id ID
 * @property int $group_id 分组ID
 * @property int $attribute_set_id 属性集ID
 * @property int $attribute_id 属性ID
 */
class EntityAttribute extends Model
{
    public bool $timestamps = false;

    /**
     * The table associated with the model.
     */
    protected ?string $table = 'entity_attribute';

    /**
     * The attributes that are mass assignable.
     */
    protected array $fillable = ['id', 'group_id', 'attribute_set_id', 'attribute_id'];

    /**
     * The attributes that should be cast to native types.
     */
    protected array $casts = ['id' => 'integer', 'group_id' => 'integer', 'attribute_set_id' => 'integer', 'attribute_id' => 'integer'];
}

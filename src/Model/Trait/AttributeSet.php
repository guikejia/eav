<?php

declare(strict_types=1);

namespace Guikejia\Eav\Model\Trait;

use Carbon\Carbon;
use Hyperf\Database\Model\SoftDeletes;

/**
 * @property int $id ID
 * @property string $name 名称
 * @property int $entity_type_id 类别ID
 * @property Carbon $created_at 创建时间
 * @property Carbon $updated_at 更新时间
 * @property string $deleted_at 删除时间
 * @property null|Attribute[] $attribute
 * @property null|EntityType $entity_type
 * @property null|AttributeGroup[] $attribute_groups
 */
trait AttributeSet
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     */
    protected ?string $table = 'attribute_set';

    /**
     * The attributes that are mass assignable.
     */
    protected array $fillable = ['id', 'name', 'entity_type_id', 'created_at', 'updated_at', 'deleted_at'];

    /**
     * The attributes that should be cast to native types.
     */
    protected array $casts = ['id' => 'integer', 'entity_type_id' => 'integer', 'created_at' => 'datetime', 'updated_at' => 'datetime'];

    public function attribute_groups(): \Hyperf\Database\Model\Relations\HasMany
    {
        return $this->hasMany(AttributeGroup::class, 'id', 'attribute_set_id');
    }

    public function attribute(): \Hyperf\Database\Model\Relations\BelongsToMany
    {
        return $this->belongsToMany(Attribute::class, 'entity_attribute', 'attribute_set_id', 'attribute_id');
    }

    public function entity_type(): \Hyperf\Database\Model\Relations\BelongsTo
    {
        return $this->belongsTo(EntityType::class, 'entity_type_id', 'id');
    }
}
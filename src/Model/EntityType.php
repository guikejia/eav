<?php

declare(strict_types=1);

namespace Guikejia\Eav\Model;

/**
 * @property int $id ID
 * @property string $code 类别标识
 * @property string $entity_table 实体表
 * @property string $entity_id_field 实体主键ID
 * @property string $default_attribute_set_id 默认属性集
 */
class EntityType extends EavModel
{
    use \Guikejia\Eav\Model\Trait\EntityType;

    public bool $timestamps = false;

    /**
     * The table associated with the model.
     */
    protected ?string $table = 'entity_type';

    /**
     * The attributes that are mass assignable.
     */
    protected array $fillable = ['id', 'code', 'entity_table', 'entity_id_field', 'default_attribute_set_id'];

    /**
     * The attributes that should be cast to native types.
     */
    protected array $casts = ['id' => 'integer'];
}

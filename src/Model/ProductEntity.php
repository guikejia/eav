<?php

declare(strict_types=1);

namespace Guikejia\Eav\Model;

use Carbon\Carbon;
use Hyperf\Database\Model\SoftDeletes;

/**
 * @property int $id 商品id
 * @property string $name 商品名称
 * @property int $type 1:单商品 2:捆绑商品
 * @property int $sale_type 1:到店付商品 2:核销商品(需商家核销) 3:预付商品(需商家确认) 4:线上服务(购买会员) 5:实体商品(涉及订单物流)
 * @property int $entity_type_id 实体id
 * @property int $attribute_set_id 属性集id
 * @property string $sku 商品sku
 * @property int $store_id 商品所属商家id
 * @property string $media_gallery 图片视频
 * @property string $description 商品描述
 * @property int $base_amount 基础价格
 * @property int $amount 划线价 注:用户的售价-价格规则在此基础上打折
 * @property int $store_balance_change_stage 商户余额扣减阶段 0:不进行扣减 1:支付成功进行扣减 2:商家同意进行扣减 3:商家进行核销进行扣减
 * @property int $weight 排序权限
 * @property int $is_support_auto_expired_refund 是否支持 随时退，过期自动退 1:支持 0:不支持
 * @property int $is_support_refund 是否支持退款 0:不支持 1:支持
 * @property int $is_support_checked_refund 是否支持核销后退款 0:不支持 1:支持
 * @property int $visibility 是否可见 是否在门店详情商品可见 1:可见 0:不可见
 * @property int $status 状态 1正常 0删除
 * @property int $vendor_model 库存模式 0:无库存模式(商品无库概念随便出售) 1:总库存模式 2:每日库存模式(走日历价格) 3:自定义库存模式
 * @property string $vendor_custom_model 如CNPC中石油等 vendor_model为3的时候，取此字段
 * @property string $vendor_sku 库存sku码
 * @property string $operating_labels 运营标签,多个逗号分割
 * @property string $introduce 简短介绍 如酒店行业 1张特大床或 2张单人床 36-44m2
 * @property int $created_by 创建人
 * @property Carbon $created_at 创建时间
 * @property Carbon $updated_at 修改时间
 * @property string $deleted_at 删除时间
 * @property null|AttributeSet $attribute_set
 */
class ProductEntity extends WithAttribute
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     */
    protected ?string $table = 'product_entity';

    /**
     * The attributes that are mass assignable.
     */
    protected array $fillable = ['id', 'name', 'type', 'sale_type', 'entity_type_id', 'attribute_set_id', 'sku', 'store_id', 'media_gallery', 'description', 'base_amount', 'amount', 'store_balance_change_stage', 'weight', 'is_support_auto_expired_refund', 'is_support_refund', 'is_support_checked_refund', 'visibility', 'status', 'vendor_model', 'vendor_custom_model', 'vendor_sku', 'operating_labels', 'introduce', 'created_by', 'created_at', 'updated_at', 'deleted_at'];

    /**
     * The attributes that should be cast to native types.
     */
    protected array $casts = ['id' => 'integer', 'type' => 'integer', 'sale_type' => 'integer', 'entity_type_id' => 'integer', 'attribute_set_id' => 'integer', 'store_id' => 'integer', 'base_amount' => 'integer', 'amount' => 'integer', 'store_balance_change_stage' => 'integer', 'weight' => 'integer', 'is_support_auto_expired_refund' => 'integer', 'is_support_refund' => 'integer', 'is_support_checked_refund' => 'integer', 'visibility' => 'integer', 'status' => 'integer', 'vendor_model' => 'integer', 'created_by' => 'integer', 'created_at' => 'datetime', 'updated_at' => 'datetime'];
}

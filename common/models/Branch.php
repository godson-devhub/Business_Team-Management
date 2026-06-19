<?php

declare(strict_types=1);

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * Branch Model (ERP CORE)
 *
 * Business → has many branches
 * Branch → has sellers + products + sales
 *
 * @property int $id
 * @property int $business_id
 * @property string $name
 * @property string|null $location
 * @property int $created_at
 * @property int $updated_at
 */
class Branch extends ActiveRecord
{
    /**
     * TABLE NAME
     */
    public static function tableName(): string
    {
        return '{{%branch}}';
    }

    /**
     * TIMESTAMPS
     */
    public function behaviors(): array
    {
        return [
            TimestampBehavior::class,
        ];
    }

    /**
     * VALIDATION RULES
     */
    public function rules(): array
    {
        return [

            [['name', 'business_id'], 'required'],

            [['business_id'], 'integer'],

            [['location'], 'string'],

            [['name'], 'string', 'max' => 255],

            [
                ['business_id'],
                'exist',
                'targetClass' => Business::class,
                'targetAttribute' => ['business_id' => 'id'],
                'message' => 'Business does not exist'
            ],
        ];
    }

    // =========================
    // RELATIONS
    // =========================

    /**
     * Branch belongs to Business
     */
    public function getBusiness()
    {
        return $this->hasOne(Business::class, ['id' => 'business_id']);
    }

    /**
     * Branch has many sellers (users)
     */
    public function getSellers()
    {
        return $this->hasMany(User::class, ['branch_id' => 'id']);
    }

    /**
     * Branch has many products
     */
    public function getProducts()
    {
        return $this->hasMany(Product::class, ['branch_id' => 'id']);
    }

    /**
     * Branch has many sales
     */
    public function getSales()
    {
        return $this->hasMany(Sale::class, ['branch_id' => 'id']);
    }

    /**
     * Branch has many purchases
     */
    public function getPurchases()
    {
        return $this->hasMany(Purchase::class, ['branch_id' => 'id']);
    }

    //active sellers
    public function getActiveSellers()
    {
        return $this->hasMany(User::class, ['branch_id' => 'id'])
            ->andWhere(['status' => User::STATUS_ACTIVE])
            ->andWhere(['role' => User::ROLE_SELLER]);
    }

    // =========================
    // HELPERS (ANALYTICS READY)
    // =========================

    /**
     * Total sellers in branch
     */
    public function getSellerCount(): int
    {
        return (int) $this->getSellers()->count();
    }

    /**
     * Total products in branch
     */
    public function getProductCount(): int
    {
        return (int) $this->getProducts()->count();
    }

    /**
     * Total sales in branch
     */
    public function getTotalSales(): float
    {
        return (float) Sale::find()
            ->where(['branch_id' => $this->id])
            ->sum('total_amount');
    }

    /**
     * Total profit in branch
     */
    public function getTotalProfit(): float
    {
        return (float) Sale::find()
            ->where(['branch_id' => $this->id])
            ->sum('total_profit');
    }

    /**
     * Low stock products count
     */
    public function getLowStockCount(): int
    {
        return (int) Product::find()
            ->where(['branch_id' => $this->id])
            ->andWhere(['<=', 'stock_quantity', 5])
            ->count();
    }
}
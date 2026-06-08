<?php

declare(strict_types=1);

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * Business Model
 *
 * OWNER owns many businesses
 *
 * @property int $id
 * @property int $owner_id
 * @property string $name
 * @property string|null $description
 * @property int $created_at
 * @property int $updated_at
 */
class Business extends ActiveRecord
{
    /**
     * TABLE NAME
     */
    public static function tableName(): string
    {
        return '{{%business}}';
    }

    /**
     * TIMESTAMPS (created_at, updated_at)
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

            [['name', 'owner_id'], 'required'],

            [['owner_id'], 'integer'],

            [['description'], 'string'],

            [['name'], 'string', 'max' => 255],

            [
                ['owner_id'],
                'exist',
                'targetClass' => User::class,
                'targetAttribute' => ['owner_id' => 'id'],
                'filter' => ['role' => User::ROLE_OWNER],
                'message' => 'Owner must be a valid owner user'
            ],
        ];
    }

    // =========================
    // RELATIONSHIPS
    // =========================

    /**
     * Business belongs to owner (User)
     */
    public function getOwner()
    {
        return $this->hasOne(User::class, ['id' => 'owner_id']);
    }

    /**
     * Business has many branches
     */
    public function getBranches()
    {
        return $this->hasMany(Branch::class, ['business_id' => 'id']);
    }

    /**
     * Business has many products (through branches indirectly)
     */
    public function getProducts()
    {
        return $this->hasMany(Product::class, ['business_id' => 'id']);
    }

    /**
     * Business has many sales (through branches)
     */
    public function getSales()
    {
        return $this->hasMany(Sale::class, ['business_id' => 'id']);
    }

    // =========================
    // HELPERS
    // =========================

    /**
     * Total branches count
     */
    public function getBranchCount(): int
    {
        return (int) $this->getBranches()->count();
    }

    /**
     * Total products count (through branches if needed later)
     */
    public function getProductCount(): int
    {
        return (int) Product::find()
            ->where(['business_id' => $this->id])
            ->count();
    }

    /**
     * Total sales for this business
     */
    public function getTotalSales(): float
    {
        return (float) Sale::find()
            ->where(['business_id' => $this->id])
            ->sum('total_amount');
    }

    /**
     * Total profit for this business
     */
    public function getTotalProfit(): float
    {
        return (float) Sale::find()
            ->where(['business_id' => $this->id])
            ->sum('total_profit');
    }
}
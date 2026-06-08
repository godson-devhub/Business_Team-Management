<?php

declare(strict_types=1);

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * Product Model (ERP CORE INVENTORY)
 *
 * Branch → has many products
 *
 * @property int $id
 * @property int $branch_id
 * @property string $name
 * @property float $buying_price
 * @property float $selling_price
 * @property int $stock_quantity
 * @property int $low_stock_threshold
 * @property string|null $description
 * @property int $created_at
 * @property int $updated_at
 */
class Product extends ActiveRecord
{
    /**
     * TABLE NAME
     */
    public static function tableName(): string
    {
        return '{{%product}}';
    }

    /**
     * TIMESTAMP BEHAVIOR
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

            [['name', 'branch_id', 'buying_price', 'selling_price'], 'required'],

            [['branch_id', 'stock_quantity', 'low_stock_threshold'], 'integer'],

            [['buying_price', 'selling_price'], 'number'],

            [['description'], 'string'],

            [['name'], 'string', 'max' => 255],

            ['stock_quantity', 'default', 'value' => 0],

            ['low_stock_threshold', 'default', 'value' => 5],

            [
                ['branch_id'],
                'exist',
                'targetClass' => Branch::class,
                'targetAttribute' => ['branch_id' => 'id'],
                'message' => 'Branch does not exist'
            ],
        ];
    }

    // =========================
    // RELATIONS
    // =========================

    /**
     * Product belongs to branch
     */
    public function getBranch()
    {
        return $this->hasOne(Branch::class, ['id' => 'branch_id']);
    }

    /**
     * Product → Sale Items
     */
    public function getSaleItems()
    {
        return $this->hasMany(SaleItem::class, ['product_id' => 'id']);
    }

    /**
     * Product → Purchase Items
     */
    public function getPurchaseItems()
    {
        return $this->hasMany(PurchaseItem::class, ['product_id' => 'id']);
    }

    // =========================
    // BUSINESS LOGIC HELPERS
    // =========================

    /**
     * Check if stock is low
     */
    public function isLowStock(): bool
    {
        return $this->stock_quantity <= $this->low_stock_threshold;
    }

    /**
     * Calculate profit per unit
     */
    public function getUnitProfit(): float
    {
        return (float) ($this->selling_price - $this->buying_price);
    }

    /**
     * Increase stock (purchase)
     */
    public function increaseStock(int $qty): bool
    {
        $this->stock_quantity += $qty;
        return $this->save(false);
    }

    /**
     * Decrease stock (sale)
     */
    public function decreaseStock(int $qty): bool
    {
        if ($this->stock_quantity < $qty) {
            return false;
        }

        $this->stock_quantity -= $qty;
        return $this->save(false);
    }

    /**
     * Total value of stock (inventory value)
     */
    public function getStockValue(): float
    {
        return (float) ($this->stock_quantity * $this->buying_price);
    }
}
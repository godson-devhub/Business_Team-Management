<?php

declare(strict_types=1);

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * Product Model (ERP CORE INVENTORY - CLEAN VERSION)
 */
class Product extends ActiveRecord
{
    public static function tableName(): string
    {
        return '{{%product}}';
    }

    public function behaviors(): array
    {
        return [
            TimestampBehavior::class,
        ];
    }

    /* =========================
     * VALIDATION RULES
     * ========================= */
    public function rules(): array
    {
        return [

            // REQUIRED FIELDS
            [['name', 'branch_id', 'buying_price', 'selling_price'], 'required'],

            // TYPES (MATCH DATABASE)
            [['branch_id', 'stock_quantity', 'min_stock_alert', 'status'], 'integer'],

            [['buying_price', 'selling_price'], 'number'],

            [['name'], 'string', 'max' => 255],

            // DEFAULT VALUES
            ['stock_quantity', 'default', 'value' => 0],
            ['min_stock_alert', 'default', 'value' => 5],
            ['status', 'default', 'value' => 1],

            // SAFETY VALIDATION
            ['stock_quantity', 'integer', 'min' => 0],
            ['min_stock_alert', 'integer', 'min' => 0],
            ['buying_price', 'number', 'min' => 0],
            ['selling_price', 'number', 'min' => 0],

            ['sku', 'unique'],
            [['created_by'], 'required'],
        ];
    }

    /* =========================
     * RELATIONS
     * ========================= */

    public function getBranch()
    {
        return $this->hasOne(Branch::class, ['id' => 'branch_id']);
    }

    public function getSaleItems()
    {
        return $this->hasMany(SaleItem::class, ['product_id' => 'id']);
    }

    public function getPurchaseItems()
    {
        return $this->hasMany(PurchaseItem::class, ['product_id' => 'id']);
    }

    public function getStockMovements()
    {
        return $this->hasMany(StockMovement::class, ['product_id' => 'id']);
    }

    /* =========================
     * BUSINESS LOGIC
     * ========================= */

    public function getIsLowStock(): bool
    {
        return $this->stock_quantity <= ($this->min_stock_alert ?? 5);
    }

    public function getUnitProfit(): float
    {
        return (float) ($this->selling_price - $this->buying_price);
    }

    /* =========================
     * STOCK IN (PURCHASE)
     * ========================= */
    public function increaseStock(int $qty): bool
    {
        if ($qty <= 0) {
            return false;
        }

        $this->stock_quantity += $qty;

        $saved = $this->save(false);

        if ($saved && class_exists(StockMovement::class)) {
            StockMovement::logMovement(
                $this->id,
                $this->branch_id,
                'IN',
                $qty,
                'Stock IN (Purchase)'
            );
        }

        return $saved;
    }

    /* =========================
     * STOCK OUT (SALE)
     * ========================= */
    public function decreaseStock(int $qty): bool
    {
        if ($qty <= 0 || $this->stock_quantity < $qty) {
            return false;
        }

        $previousStock = (int) $this->stock_quantity;
        $this->stock_quantity -= $qty;

        $saved = $this->save(false);

        if ($saved && class_exists(StockMovement::class)) {
            StockMovement::logMovement(
                (int)$this->id,
                (int)$this->branch_id,
                (int)Yii::$app->user->id,
                'OUT',
                (int)$qty,
                $previousStock,
                (int)$this->stock_quantity,
                'Stock OUT (Sale)'
            );
        }

        return $saved;
    }

    /* =========================
     * STOCK VALUE
     * ========================= */
    public function getStockValue(): float
    {
        return (float) ($this->stock_quantity * $this->selling_price);
    }
}
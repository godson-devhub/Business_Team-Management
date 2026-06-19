<?php

declare(strict_types=1);

namespace common\models;

use Yii;
use yii\db\ActiveRecord;
use common\models\Product;
use common\models\Sale;
use common\models\StockMovement;

/**
 * SaleItem (FINAL CLEAN + SAFE + PRODUCTION READY)
 */
class SaleItem extends ActiveRecord
{
    public static function tableName(): string
    {
        return '{{%sale_items}}';
    }

    // =========================
    // RULES
    // =========================
    public function rules(): array
    {
        return [
            [['sale_id', 'product_id', 'quantity', 'selling_price'], 'required'],
            [['sale_id', 'product_id', 'quantity'], 'integer'],
            [['selling_price', 'buying_price', 'profit', 'subtotal'], 'number'],
            ['quantity', 'integer', 'min' => 1],
        ];
    }

    // =========================
    // RELATIONS
    // =========================
    public function getSale()
    {
        return $this->hasOne(Sale::class, ['id' => 'sale_id']);
    }

    public function getProduct()
    {
        return $this->hasOne(Product::class, ['id' => 'product_id']);
    }

    // =========================
    // AFTER SAVE (SAFE STOCK OUT SYSTEM)
    // =========================
    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);

        // 🔥 prevent double execution on update
        if (!$insert) {
            return;
        }

        $product = Product::findOne($this->product_id);

        if (!$product) {
            return;
        }

        // =========================
        // STOCK VALIDATION (SAFETY)
        // =========================
        if ($product->stock_quantity < $this->quantity) {
            return;
        }

        $previousStock = (int) $product->stock_quantity;
        $newStock = $previousStock - (int) $this->quantity;

        // =========================
        // UPDATE STOCK
        // =========================
        $product->stock_quantity = $newStock;
        $product->save(false);

        // =========================
        // CALCULATE FINANCIALS
        // =========================
        $profit   = ($this->selling_price - $product->buying_price) * $this->quantity;
        $subtotal = $this->selling_price * $this->quantity;

        // update current item safely (no recursion risk)
        self::updateAll(
            [
                'profit' => $profit,
                'subtotal' => $subtotal
            ],
            ['id' => $this->id]
        );

        // =========================
        // UPDATE SALE TOTALS (AUTO RE-CALC)
        // =========================
        $sale = Sale::findOne($this->sale_id);

        if ($sale) {

            $sale->total_profit = (float) self::find()
                ->where(['sale_id' => $sale->id])
                ->sum('profit');

            $sale->total_amount = (float) self::find()
                ->where(['sale_id' => $sale->id])
                ->sum('subtotal');

            $sale->save(false);
        }

        // =========================
        // STOCK MOVEMENT LOG (AUDIT)
        // =========================
        $movement = new StockMovement();

        $movement->product_id = $product->id;
        $movement->branch_id   = $product->branch_id;
        $movement->user_id     = Yii::$app->user->id;
        $movement->type        = 'OUT';
        $movement->quantity    = $this->quantity;

        $movement->previous_stock = $previousStock;
        $movement->new_stock      = $newStock;

        $movement->note =
            'Sale #' . $this->sale_id .
            ' | Product: ' . $product->name;

        $movement->save(false);
    }

    // =========================
    // HELPERS
    // =========================
    public function getLineTotal(): float
    {
        return (float) ($this->quantity * $this->selling_price);
    }

    public function getProfitPerUnit(): float
    {
        return (float) ($this->selling_price - $this->buying_price);
    }
}
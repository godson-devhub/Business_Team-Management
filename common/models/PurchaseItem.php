<?php

declare(strict_types=1);

namespace common\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * Purchase Item (Stock IN Line Item - REALTIME SAFE)
 */
class PurchaseItem extends ActiveRecord
{
    public static function tableName(): string
    {
        return '{{%purchase_items}}';
    }

    // =========================
    // RULES
    // =========================
    public function rules(): array
    {
        return [
            [['purchase_id', 'product_id', 'quantity', 'buying_price'], 'required'],
            [['purchase_id', 'product_id', 'quantity'], 'integer'],
            [['buying_price'], 'number'],
            ['quantity', 'integer', 'min' => 1],
            ['buying_price', 'number', 'min' => 0],
        ];
    }

    // =========================
    // AFTER SAVE (CREATE ONLY)
    // =========================
    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);

      

       
       
    }

    // =========================
    // RELATIONS
    // =========================
    public function getPurchase()
    {
        return $this->hasOne(Purchase::class, ['id' => 'purchase_id']);
    }

    public function getProduct()
    {
        return $this->hasOne(Product::class, ['id' => 'product_id']);
    }

    // =========================
    // BUSINESS LOGIC
    // =========================

    /**
     * Total cost of this line item
     */
    public function getTotalCost(): float
    {
        return (float) ((int) $this->quantity * (float) $this->buying_price);
    }

    /**
     * Product name helper (UI)
     */
    public function getLabel(): string
    {
        return $this->product->name ?? 'Unknown Product';
    }
}
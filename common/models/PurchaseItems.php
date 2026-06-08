<?php

declare(strict_types=1);

namespace common\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * Purchase Item (adds stock)
 *
 * @property int $id
 * @property int $purchase_id
 * @property int $product_id
 * @property int $quantity
 * @property float $buying_price
 */
class PurchaseItem extends ActiveRecord
{
    public static function tableName(): string
    {
        return '{{%purchase_items}}';
    }

    public function rules(): array
    {
        return [
            [['purchase_id', 'product_id', 'quantity', 'buying_price'], 'required'],
            [['purchase_id', 'product_id', 'quantity'], 'integer'],
            [['buying_price'], 'number'],
        ];
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);

        $product = Product::findOne($this->product_id);

        if ($product) {
            $product->increaseStock($this->quantity);
        }
    }
}
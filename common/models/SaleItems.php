<?php

declare(strict_types=1);

namespace common\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * Sale Item (reduces stock)
 *
 * @property int $id
 * @property int $sale_id
 * @property int $product_id
 * @property int $quantity
 * @property float $selling_price
 * @property float $profit
 */
class SaleItem extends ActiveRecord
{
    public static function tableName(): string
    {
        return '{{%sale_items}}';
    }

    public function rules(): array
    {
        return [
            [['sale_id', 'product_id', 'quantity', 'selling_price'], 'required'],
            [['sale_id', 'product_id', 'quantity'], 'integer'],
            [['selling_price', 'profit'], 'number'],
        ];
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);

        $product = Product::findOne($this->product_id);

        if ($product) {

            // reduce stock
            $product->decreaseStock($this->quantity);

            // calculate profit
            $this->profit = ($this->selling_price - $product->buying_price) * $this->quantity;
            $this->save(false);
        }
    }
}
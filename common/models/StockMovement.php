<?php

declare(strict_types=1);

namespace common\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * Stock Movement (Audit Trail)
 *
 * Tracks all stock changes
 *
 * @property int $id
 * @property int $product_id
 * @property int $branch_id
 * @property string $type (IN / OUT)
 * @property int $quantity
 * @property string|null $note
 * @property int $created_at
 */
class StockMovement extends ActiveRecord
{
    public static function tableName(): string
    {
        return '{{%stock_movement}}';
    }

    public function rules(): array
    {
        return [
            [['product_id', 'branch_id', 'type', 'quantity'], 'required'],
            [['product_id', 'branch_id', 'quantity'], 'integer'],
            [['type'], 'string'],
            [['note'], 'string'],
        ];
    }

    public function behaviors(): array
    {
        return [
            'timestamp' => [
                'class' => \yii\behaviors\TimestampBehavior::class,
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => false,
            ],
        ];
    }

    public function getProduct()
    {
        return $this->hasOne(Product::class, ['id' => 'product_id']);
    }
}
<?php

declare(strict_types=1);

namespace common\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;

/**
 * Sale (Stock OUT)
 *
 * @property int $id
 * @property int $branch_id
 * @property int $created_by
 * @property float $total_amount
 * @property float $total_profit
 * @property int $created_at
 * @property int $updated_at
 */
class Sale extends ActiveRecord
{
    public static function tableName(): string
    {
        return '{{%sale}}';
    }

    public function behaviors(): array
    {
        return [TimestampBehavior::class];
    }

    public function rules(): array
    {
        return [
            [['branch_id', 'created_by'], 'required'],
            [['branch_id', 'created_by'], 'integer'],
            [['total_amount', 'total_profit'], 'number'],
        ];
    }

    public function getItems()
    {
        return $this->hasMany(SaleItem::class, ['sale_id' => 'id']);
    }
}
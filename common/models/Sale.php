<?php

declare(strict_types=1);

namespace common\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;

/**
 * Sale (Stock OUT)
 */
class Sale extends ActiveRecord
{
    public static function tableName(): string
    {
        return '{{%sale}}';
    }

    public function behaviors(): array
    {
        return [
            [
                'class' => TimestampBehavior::class,
                
            ],
        ];
    }

    public function rules(): array
    {
        return [
            [['branch_id', 'user_id'], 'required'],
            [['branch_id', 'user_id'], 'integer'],
            [['total_amount', 'total_profit'], 'number'],

            ['status', 'string'],
        ];
    }

    public function getItems()
    {
        return $this->hasMany(SaleItem::class, ['sale_id' => 'id']);
    }

    public function getBranch()
    {
        return $this->hasOne(Branch::class, ['id' => 'branch_id']);
    }

    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }
}
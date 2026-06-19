<?php

declare(strict_types=1);

namespace common\models;

use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;

class Purchase extends ActiveRecord
{
    public static function tableName(): string
    {
        return '{{%purchase}}';
    }

    public function behaviors(): array
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => false,
            ],
        ];
    }

    public function rules(): array
    {
        return [

            [
                [
                    'business_id',
                    'branch_id',
                    'user_id'
                ],
                'required'
            ],

            [
                [
                    'business_id',
                    'branch_id',
                    'user_id',
                    'created_at'
                ],
                'integer'
            ],

            [
                'total_amount',
                'number'
            ],

            [
                'supplier_name',
                'string',
                'max' => 255
            ],

            [
                'supplier_contact',
                'string',
                'max' => 20
            ],

            [
                'status',
                'in',
                'range' => [
                    'pending',
                    'completed',
                    'received',
                    'cancelled'
                ]
            ],
        ];
    }

    public function getItems()
    {
        return $this->hasMany(
            PurchaseItem::class,
            ['purchase_id' => 'id']
        );
    }

    public function getBranch()
    {
        return $this->hasOne(
            Branch::class,
            ['id' => 'branch_id']
        );
    }

    public function getUser()
    {
        return $this->hasOne(
            User::class,
            ['id' => 'user_id']
        );
    }

    public function getBusiness()
    {
        return $this->hasOne(
            Business::class,
            ['id' => 'business_id']
        );
    }
}
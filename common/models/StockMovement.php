<?php

declare(strict_types=1);

namespace common\models;

use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;

class StockMovement extends ActiveRecord
{
    public static function tableName(): string
    {
        return '{{%stock_movement}}';
    }

    public function rules(): array
    {
        return [

            [
                [
                    'product_id',
                    'branch_id',
                    'user_id',
                    'type',
                    'quantity',
                    'previous_stock',
                    'new_stock'
                ],
                'required'
            ],

            [
                [
                    'product_id',
                    'branch_id',
                    'user_id',
                    'quantity',
                    'previous_stock',
                    'new_stock'
                ],
                'integer'
            ],

            [
                'type',
                'in',
                'range' => [
                    'IN',
                    'OUT',
                    'ADJUSTMENT'
                ]
            ],

            ['note', 'string'],
        ];
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

    public function getProduct()
    {
        return $this->hasOne(Product::class, ['id' => 'product_id']);
    }

    public function getBranch()
    {
        return $this->hasOne(Branch::class, ['id' => 'branch_id']);
    }

    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    public static function logMovement(
        int $productId,
        int $branchId,
        int $userId,
        string $type,
        int $qty,
        int $previousStock,
        int $newStock,
        ?string $note = null
    ): void {

        $movement = new self();

        $movement->product_id = $productId;
        $movement->branch_id = $branchId;
        $movement->user_id = $userId;

        $movement->type = $type;
        $movement->quantity = $qty;

        $movement->previous_stock = $previousStock;
        $movement->new_stock = $newStock;

        $movement->note = $note;

        if (!$movement->save()) {

            throw new \Exception(
                json_encode($movement->errors)
            );
        }
    }
}
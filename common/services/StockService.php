<?php

namespace common\services;

use common\models\Product;
use common\models\StockMovement;
use Yii;

class StockService
{
    // =========================
    // REDUCE STOCK (SALE)
    // =========================
    public static function reduceStock($productId, $branchId, $userId, $quantity, $note = null)
    {
        $product = Product::findOne($productId);

        if (!$product) {
            throw new \Exception("Product not found");
        }

        $previousStock = $product->stock_quantity;

        if ($previousStock < $quantity) {
            throw new \Exception("Insufficient stock");
        }

        $product->stock_quantity -= $quantity;
        $product->save(false);

        // LOG MOVEMENT
        self::logMovement(
            $productId,
            $branchId,
            $userId,
            'OUT',
            $quantity,
            $previousStock,
            $product->stock_quantity,
            $note
        );
    }

    // =========================
    // INCREASE STOCK (PURCHASE)
    // =========================
    public static function increaseStock($productId, $branchId, $userId, $quantity, $note = null)
    {
        $product = Product::findOne($productId);

        if (!$product) {
            throw new \Exception("Product not found");
        }

        $previousStock = $product->stock_quantity;

        $product->stock_quantity += $quantity;
        $product->save(false);

        // LOG MOVEMENT
        self::logMovement(
            $productId,
            $branchId,
            $userId,
            'IN',
            $quantity,
            $previousStock,
            $product->stock_quantity,
            $note
        );
    }

    // =========================
    // LOG MOVEMENT
    // =========================
    private static function logMovement(
        $productId,
        $branchId,
        $userId,
        $type,
        $quantity,
        $previous,
        $new,
        $note
    ) {
        $movement = new StockMovement();

        $movement->product_id = $productId;
        $movement->branch_id = $branchId;
        $movement->user_id = $userId;
        $movement->type = $type;
        $movement->quantity = $quantity;
        $movement->previous_stock = $previous;
        $movement->new_stock = $new;
        $movement->note = $note;

        $movement->save(false);
    }
}
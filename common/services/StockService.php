<?php

namespace common\services;

use common\models\Product;
use common\models\StockMovement;
use yii\web\BadRequestHttpException;

class StockService
{
    /**
     * =========================
     * STOCK IN (PURCHASE)
     * =========================
     */
    public static function increaseStock(
        int $productId,
        int $branchId,
        int $userId,
        int $quantity,
        ?string $note = null
    ): bool {

        $product = self::getProduct($productId);

        $previousStock = (int)$product->stock_quantity;

        $product->stock_quantity =
            $previousStock + $quantity;

        if (!$product->save(false)) {
            throw new BadRequestHttpException(
                'Failed to increase stock'
            );
        }

        self::logMovement(
            $productId,
            $branchId,
            $userId,
            'IN',
            $quantity,
            $previousStock,
            (int)$product->stock_quantity,
            $note
        );

        return true;
    }

    /**
     * =========================
     * STOCK OUT (SALE)
     * =========================
     */
    public static function decreaseStock(
        int $productId,
        int $branchId,
        int $userId,
        int $quantity,
        ?string $note = null
    ): bool {

        $product = self::getProduct($productId);

        $previousStock = (int)$product->stock_quantity;

        if ($previousStock < $quantity) {
            throw new BadRequestHttpException(
                'Insufficient stock'
            );
        }

        $product->stock_quantity =
            $previousStock - $quantity;

        if (!$product->save(false)) {
            throw new BadRequestHttpException(
                'Failed to decrease stock'
            );
        }

        self::logMovement(
            $productId,
            $branchId,
            $userId,
            'OUT',
            $quantity,
            $previousStock,
            (int)$product->stock_quantity,
            $note
        );

        return true;
    }

    /**
     * =========================
     * GET PRODUCT
     * =========================
     */
    private static function getProduct(
        int $productId
    ): Product {

        $product = Product::findOne($productId);

        if (!$product) {
            throw new BadRequestHttpException(
                'Product not found'
            );
        }

        return $product;
    }

    /**
     * =========================
     * STOCK MOVEMENT LOG
     * =========================
     */
    private static function logMovement(
        int $productId,
        int $branchId,
        int $userId,
        string $type,
        int $quantity,
        int $previousStock,
        int $newStock,
        ?string $note = null
    ): void {

        $movement = new StockMovement();

        $movement->product_id = $productId;
        $movement->branch_id = $branchId;
        $movement->user_id = $userId;

        $movement->type = $type;
        $movement->quantity = $quantity;

        $movement->previous_stock = $previousStock;
        $movement->new_stock = $newStock;

        $movement->note = $note;

        if (!$movement->save()) {

            throw new BadRequestHttpException(
                json_encode($movement->errors)
            );
        }
    }
}
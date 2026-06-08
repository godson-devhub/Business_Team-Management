<?php

namespace common\services;

use common\models\Product;

class StockAlertService
{
    /**
     * Get all low stock products for a branch
     */
    public static function getLowStockProducts($branchId)
    {
        return Product::find()
            ->where(['branch_id' => $branchId])
            ->andWhere('stock_quantity <= min_stock_alert')
            ->all();
    }

    /**
     * Get out of stock products
     */
    public static function getOutOfStockProducts($branchId)
    {
        return Product::find()
            ->where(['branch_id' => $branchId])
            ->andWhere(['stock_quantity' => 0])
            ->all();
    }

    /**
     * Count alerts (for dashboard badge)
     */
    public static function getAlertCount($branchId)
    {
        $low = Product::find()
            ->where(['branch_id' => $branchId])
            ->andWhere('stock_quantity <= min_stock_alert')
            ->count();

        $out = Product::find()
            ->where(['branch_id' => $branchId])
            ->andWhere(['stock_quantity' => 0])
            ->count();

        return $low + $out;
    }
}
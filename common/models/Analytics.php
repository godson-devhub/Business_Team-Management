<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\db\Query;

use common\models\Sale;
use common\models\Product;
use common\models\Branch;

class Analytics extends Model
{
    // =====================================
    // DAILY SALES
    // =====================================
    public static function getDailySales($branchId, $date)
    {
        if (!$branchId) return 0;

        return (float) Sale::find()
            ->where(['branch_id' => $branchId])
            ->andWhere([
                'between',
                'created_at',
                strtotime($date . ' 00:00:00'),
                strtotime($date . ' 23:59:59')
            ])
            ->sum('total_amount') ?? 0;
    }

    // =====================================
    // DAILY PROFIT
    // =====================================
    public static function getDailyProfit($branchId, $date)
    {
        if (!$branchId) return 0;

        return (float) Sale::find()
            ->where(['branch_id' => $branchId])
            ->andWhere([
                'between',
                'created_at',
                strtotime($date . ' 00:00:00'),
                strtotime($date . ' 23:59:59')
            ])
            ->sum('total_profit') ?? 0;
    }

    // =====================================
    // MONTHLY SALES
    // =====================================
    public static function getMonthlySales($branchId, $month)
    {
        if (!$branchId) return 0;

        return (float) Sale::find()
            ->where(['branch_id' => $branchId])
            ->andWhere([
                'between',
                'created_at',
                strtotime($month . '-01 00:00:00'),
                strtotime(date('Y-m-t 23:59:59', strtotime($month . '-01')))
            ])
            ->sum('total_amount') ?? 0;
    }

    // =====================================
    // MONTHLY PROFIT
    // =====================================
    public static function getMonthlyProfit($branchId, $month)
    {
        if (!$branchId) return 0;

        return (float) Sale::find()
            ->where(['branch_id' => $branchId])
            ->andWhere([
                'between',
                'created_at',
                strtotime($month . '-01 00:00:00'),
                strtotime(date('Y-m-t 23:59:59', strtotime($month . '-01')))
            ])
            ->sum('total_profit') ?? 0;
    }

    // =====================================
    // WEEKLY SALES CHART (7 DAYS)
    // =====================================
    public static function getWeeklySalesChart($branchId)
    {
        if (!$branchId) return [];

        $data = [];

        for ($i = 6; $i >= 0; $i--) {

            $date = date('Y-m-d', strtotime("-{$i} days"));

            $total = (float) Sale::find()
                ->where(['branch_id' => $branchId])
                ->andWhere([
                    'between',
                    'created_at',
                    strtotime($date . ' 00:00:00'),
                    strtotime($date . ' 23:59:59')
                ])
                ->sum('total_amount') ?? 0;

            $data[] = [
                'label' => date('D', strtotime($date)),
                'value' => $total
            ];
        }

        return $data;
    }

    // =====================================
    // MONTHLY SALES CHART (12 MONTHS)
    // =====================================
    public static function getMonthlySalesChart($branchId)
    {
        if (!$branchId) return [];

        $data = [];

        for ($i = 11; $i >= 0; $i--) {

            $month = date('Y-m', strtotime("-{$i} months"));

            $start = strtotime($month . '-01 00:00:00');
            $end = strtotime(date('Y-m-t 23:59:59', $start));

            $total = (float) Sale::find()
                ->where(['branch_id' => $branchId])
                ->andWhere(['between', 'created_at', $start, $end])
                ->sum('total_amount') ?? 0;

            $data[] = [
                'label' => date('M Y', $start),
                'value' => $total
            ];
        }

        return $data;
    }

    // =====================================
    // TOTAL PRODUCTS
    // =====================================
    public static function getTotalProducts($branchId)
    {
        if (!$branchId) return 0;

        return (int) Product::find()
            ->where(['branch_id' => $branchId])
            ->count();
    }

    // =====================================
    // STOCK VALUE
    // =====================================
    public static function getStockValue($branchId)
    {
        if (!$branchId) return 0;

        $products = Product::find()
            ->where(['branch_id' => $branchId])
            ->all();

        $value = 0;

        foreach ($products as $product) {
            $value += (float)(
                $product->buying_price * $product->stock_quantity
            );
        }

        return $value;
    }

    // =====================================
    // LOW STOCK PRODUCTS
    // =====================================
    public static function getLowStockProducts($branchId)
    {
        if (!$branchId) return [];

        return Product::find()
            ->where(['branch_id' => $branchId])
            ->andWhere(['<=', 'stock_quantity', 'min_stock_alert'])
            ->all();
    }

    // =====================================
    // OUT OF STOCK PRODUCTS
    // =====================================
    public static function getOutOfStockProducts($branchId)
    {
        if (!$branchId) return [];

        return Product::find()
            ->where([
                'branch_id' => $branchId,
                'stock_quantity' => 0
            ])
            ->all();
    }

    // =====================================
    // TOP SELLING PRODUCTS
    // =====================================
    public static function getTopSellingProducts($branchId, $limit = 10)
    {
        if (!$branchId) return [];

        return (new Query())
            ->select([
                'p.id',
                'p.name',
                'SUM(si.quantity) AS total_sold'
            ])
            ->from('sale_items si')
            ->innerJoin('product p', 'p.id = si.product_id')
            ->innerJoin('sale s', 's.id = si.sale_id')
            ->where(['s.branch_id' => $branchId])
            ->groupBy(['p.id', 'p.name'])
            ->orderBy(['total_sold' => SORT_DESC])
            ->limit($limit)
            ->all();
    }

    // =====================================
    // BRANCH LIST
    // =====================================
    public static function getBranches()
    {
        return Branch::find()
            ->orderBy(['name' => SORT_ASC])
            ->all();
    }
}
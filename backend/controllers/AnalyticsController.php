<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;

use common\models\Sale;
use common\models\Purchase;
use common\models\Product;

class AnalyticsController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $user = Yii::$app->user->identity;

        // =========================
        // BRANCH SAFETY
        // =========================
        $branchId = $user->branch_id ?? null;

        if (!$branchId) {
            throw new \yii\web\BadRequestHttpException("Branch not assigned to this user.");
        }

        // =========================
        // SALES DATA
        // =========================
        $totalSales = Sale::find()
            ->where(['branch_id' => $branchId])
            ->sum('total_amount') ?? 0;

        $totalProfit = Sale::find()
            ->where(['branch_id' => $branchId])
            ->sum('total_profit') ?? 0;

        // =========================
        // PURCHASES DATA
        // =========================
        $totalPurchases = Purchase::find()
            ->where(['branch_id' => $branchId])
            ->sum('total_amount') ?? 0;

        // =========================
        // PRODUCTS DATA
        // =========================
        $totalProducts = Product::find()
            ->where(['branch_id' => $branchId])
            ->count();

        $lowStock = Product::find()
            ->where(['branch_id' => $branchId])
            ->andWhere(['<=', 'stock_quantity', 5])
            ->count();

        // =========================
        // TOP PRODUCTS
        // =========================
        $topProducts = Product::find()
            ->where(['branch_id' => $branchId])
            ->orderBy(['stock_quantity' => SORT_ASC])
            ->limit(5)
            ->all();

        // =========================
        // 🚨 STOCK ALERT DATA
        // =========================

        $lowStockProducts = Product::find()
            ->where(['branch_id' => $branchId])
            ->andWhere(['<=', 'stock_quantity', 5])
            ->all();

        $outStockProducts = Product::find()
            ->where(['branch_id' => $branchId])
            ->andWhere(['stock_quantity' => 0])
            ->all();

        // =========================
        // 📊 CHART DATA (SALES)
        // =========================
        $salesData = Sale::find()
            ->select(["DATE(created_at) as date", "SUM(total_amount) as total"])
            ->where(['branch_id' => $branchId])
            ->groupBy(["DATE(created_at)"])
            ->orderBy(['date' => SORT_ASC])
            ->asArray()
            ->all();

        // =========================
        // 📊 CHART DATA (PROFIT)
        // =========================
        $profitData = Sale::find()
            ->select(["DATE(created_at) as date", "SUM(total_profit) as total"])
            ->where(['branch_id' => $branchId])
            ->groupBy(["DATE(created_at)"])
            ->orderBy(['date' => SORT_ASC])
            ->asArray()
            ->all();

        // =========================
        // RETURN VIEW
        // =========================
        return $this->render('index', [

            // FINANCIALS
            'totalSales' => $totalSales,
            'totalProfit' => $totalProfit,
            'totalPurchases' => $totalPurchases,

            // PRODUCTS
            'totalProducts' => $totalProducts,
            'lowStock' => $lowStock,
            'topProducts' => $topProducts,

            // STOCK ALERTS
            'lowStockProducts' => $lowStockProducts ?? [],
            'outStockProducts' => $outStockProducts ?? [],

            // CHARTS
            'salesData' => $salesData,
            'profitData' => $profitData,

        ]);
    }
}
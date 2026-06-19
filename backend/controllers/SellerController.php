<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\web\ForbiddenHttpException;

use common\models\Product;
use common\models\Sale;

class SellerController extends Controller
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
                        'matchCallback' => function () {
                            return Yii::$app->user->identity
                                && Yii::$app->user->identity->role === 'seller';
                        }
                    ],
                ],
            ],
        ];
    }

    /**
     * Seller Dashboard
     */
    public function actionIndex()
    {
        $user = Yii::$app->user->identity;

        if (!$user || !$user->branch_id) {
            throw new ForbiddenHttpException(
                'No branch assigned to this seller.'
            );
        }

        $branchId = $user->branch_id;

        // Today's sales
        $todaySales = (float) Sale::find()
            ->where(['branch_id' => $branchId])
            ->andWhere(['>=', 'created_at', strtotime(date('Y-m-d 00:00:00'))])
            ->sum('total_amount');

        // Today's profit
        $todayProfit = (float) Sale::find()
            ->where(['branch_id' => $branchId])
            ->andWhere(['>=', 'created_at', strtotime(date('Y-m-d 00:00:00'))])
            ->sum('total_profit');

        // Total products
        $totalProducts = (int) Product::find()
            ->where(['branch_id' => $branchId])
            ->count();

        // Low stock products
        $lowStock = (int) Product::find()
            ->where(['branch_id' => $branchId])
            ->andWhere('stock_quantity <= min_stock_alert')
            ->count();

        // Total stock quantity
        $totalStockQuantity = (int) Product::find()
            ->where(['branch_id' => $branchId])
            ->sum('stock_quantity');

        // Total stock value
        $products = Product::find()
            ->where(['branch_id' => $branchId])
            ->all();

        $totalStockValue = 0;

        foreach ($products as $product) {
            $totalStockValue += (
                $product->stock_quantity *
                $product->buying_price
            );
        }

        // Recent products
        $recentProducts = Product::find()
            ->where(['branch_id' => $branchId])
            ->orderBy(['id' => SORT_DESC])
            ->limit(10)
            ->all();

        return $this->render('index', [
            'todaySales' => $todaySales,
            'todayProfit' => $todayProfit,
            'totalProducts' => $totalProducts,
            'lowStock' => $lowStock,
            'totalStockQuantity' => $totalStockQuantity,
            'totalStockValue' => $totalStockValue,
            'recentProducts' => $recentProducts,
        ]);
    }
}

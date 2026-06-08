<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;
use common\models\Sale;
use common\models\Product;

class RealtimeController extends Controller
{
    public $enableCsrfValidation = false;

    public function actionStats()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $user = Yii::$app->user->identity;
        $branchId = $user->branch_id;

        $totalSales = Sale::find()
            ->where(['branch_id' => $branchId])
            ->sum('total_amount');

        $totalProfit = Sale::find()
            ->where(['branch_id' => $branchId])
            ->sum('total_profit');

        $lowStock = Product::find()
            ->where(['branch_id' => $branchId])
            ->andWhere(['<=', 'stock_quantity', 5])
            ->count();

        return [
            'totalSales' => $totalSales ?: 0,
            'totalProfit' => $totalProfit ?: 0,
            'lowStock' => $lowStock ?: 0,
        ];
    }
}
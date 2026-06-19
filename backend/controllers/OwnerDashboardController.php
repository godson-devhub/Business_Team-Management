<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\web\ForbiddenHttpException;

use common\models\Business;
use common\models\Branch;
use common\models\Product;
use common\models\Sale;
use common\models\User;
use common\models\Purchase;

class OwnerDashboardController extends Controller
{
    /**
     * ACCESS CONTROL
     */
    public function behaviors(): array
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
                                && Yii::$app->user->identity->role === 'owner';
                        },
                    ],
                ],
            ],
        ];
    }

    /**
     * EXTRA SECURITY LAYER
     */
    public function beforeAction($action)
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['/site/login']);
        }

        if (!Yii::$app->user->identity
            || Yii::$app->user->identity->role !== 'owner') {
            throw new ForbiddenHttpException('Access denied. Owner only area.');
        }

        return parent::beforeAction($action);
    }

    /**
     * OWNER DASHBOARD
     */
    public function actionIndex()
    {
        $ownerId = Yii::$app->user->id;

        /* =========================
         * BUSINESSES
         * ========================= */
        $businesses = Business::find()
            ->where(['owner_id' => $ownerId])
            ->all();

        $businessIds = Business::find()
            ->select('id')
            ->where(['owner_id' => $ownerId])
            ->column();

        if (empty($businessIds)) {
            // prevent SQL "IN ()" errors
            $businessIds = [0];
        }

        /* =========================
         * BRANCHES
         * ========================= */
        $branches = Branch::find()
            ->where(['business_id' => $businessIds])
            ->all();

        $branchIds = Branch::find()
            ->select('id')
            ->where(['business_id' => $businessIds])
            ->column();

        if (empty($branchIds)) {
            $branchIds = [0];
        }

        /* =========================
         * SALES
         * ========================= */
        $totalSales = (float) Sale::find()
            ->where(['branch_id' => $branchIds])
            ->sum('total_amount');

        $totalProfit = (float) Sale::find()
            ->where(['branch_id' => $branchIds])
            ->sum('total_profit');

        /* =========================
         * PURCHASES
         * ========================= */
        $totalPurchases = (float) Purchase::find()
            ->where(['branch_id' => $branchIds])
            ->sum('total_amount');

        /* =========================
         * PRODUCTS
         * ========================= */
        $totalProducts = (int) Product::find()
            ->where(['branch_id' => $branchIds])
            ->count();

        $lowStock = (int) Product::find()
            ->where(['branch_id' => $branchIds])
            ->andWhere(['<=', 'stock_quantity', 5])
            ->count();

        /* =========================
         * SELLERS
         * ========================= */
        $totalSellers = (int) User::find()
            ->where([
                'role' => 'seller',
                'branch_id' => $branchIds,
            ])
            ->count();

        /* =========================
         * RECENT PRODUCTS
         * ========================= */
        $recentProducts = Product::find()
            ->where(['branch_id' => $branchIds])
            ->orderBy(['id' => SORT_DESC])
            ->limit(5)
            ->all();

        /* =========================
         * SALES CHART DATA
         * ========================= */
        $salesData = Sale::find()
            ->select([
                "DATE(created_at) AS date",
                "SUM(total_amount) AS total",
            ])
            ->where(['branch_id' => $branchIds])
            ->groupBy(["DATE(created_at)"])
            ->orderBy(['date' => SORT_ASC])
            ->asArray()
            ->all();

        /* =========================
         * PROFIT CHART DATA
         * ========================= */
        $profitData = Sale::find()
            ->select([
                "DATE(created_at) AS date",
                "SUM(total_profit) AS total",
            ])
            ->where(['branch_id' => $branchIds])
            ->groupBy(["DATE(created_at)"])
            ->orderBy(['date' => SORT_ASC])
            ->asArray()
            ->all();

        /* =========================
         * RENDER VIEW
         * ========================= */
        return $this->render('index', [
            'businesses' => $businesses,
            'branches' => $branches,

            'totalSales' => $totalSales,
            'totalProfit' => $totalProfit,
            'totalPurchases' => $totalPurchases,

            'totalProducts' => $totalProducts,
            'lowStock' => $lowStock,

            'totalSellers' => $totalSellers,

            'recentProducts' => $recentProducts,
            'salesData' => $salesData,
            'profitData' => $profitData,
        ]);
    }
}
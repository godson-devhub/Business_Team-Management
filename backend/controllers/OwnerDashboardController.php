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

                            return Yii::$app
                                ->user
                                ->identity
                                ->role === 'owner';
                        },
                    ],
                ],
            ],
        ];
    }

    /**
     * EXTRA SECURITY
     */
    public function beforeAction($action)
    {
        // GUEST BLOCK
        if (Yii::$app->user->isGuest) {

            return $this->redirect(['/site/login']);
        }

        // OWNER ONLY
        if (Yii::$app->user->identity->role !== 'owner') {

            throw new ForbiddenHttpException(
                'Access denied.'
            );
        }

        return parent::beforeAction($action);
    }

    /**
     * OWNER DASHBOARD
     */
    public function actionIndex()
    {
        $ownerId = Yii::$app->user->id;

        /**
         * ============================
         * OWNER BUSINESSES
         * ============================
         */

        $businesses = Business::find()
            ->where(['owner_id' => $ownerId])
            ->all();

        /**
         * ============================
         * BUSINESS IDS
         * ============================
         */

        $businessIds = Business::find()
            ->select('id')
            ->where(['owner_id' => $ownerId])
            ->column();

        /**
         * ============================
         * OWNER BRANCHES
         * ============================
         */

        $branches = Branch::find()
            ->where(['business_id' => $businessIds])
            ->all();

        /**
         * ============================
         * BRANCH IDS
         * ============================
         */

        $branchIds = Branch::find()
            ->select('id')
            ->where(['business_id' => $businessIds])
            ->column();

        /**
         * ============================
         * TOTAL SALES
         * ============================
         */

        $totalSales = Sale::find()
            ->where(['branch_id' => $branchIds])
            ->sum('total_amount');

        /**
         * ============================
         * TOTAL PROFIT
         * ============================
         */

        $totalProfit = Sale::find()
            ->where(['branch_id' => $branchIds])
            ->sum('total_profit');

        /**
         * ============================
         * TOTAL PURCHASES
         * ============================
         */

        $totalPurchases = Purchase::find()
            ->where(['branch_id' => $branchIds])
            ->sum('total_amount');

        /**
         * ============================
         * TOTAL PRODUCTS
         * ============================
         */

        $totalProducts = Product::find()
            ->where(['branch_id' => $branchIds])
            ->count();

        /**
         * ============================
         * LOW STOCK PRODUCTS
         * ============================
         */

        $lowStock = Product::find()
            ->where(['branch_id' => $branchIds])
            ->andWhere(['<=', 'stock_quantity', 5])
            ->count();

        /**
         * ============================
         * TOTAL SELLERS
         * ============================
         */

        $totalSellers = User::find()
            ->where([
                'role' => 'seller',
                'branch_id' => $branchIds,
            ])
            ->count();

        /**
         * ============================
         * RECENT PRODUCTS
         * ============================
         */

        $recentProducts = Product::find()
            ->where(['branch_id' => $branchIds])
            ->orderBy(['id' => SORT_DESC])
            ->limit(5)
            ->all();

        /**
         * ============================
         * SALES CHART DATA
         * ============================
         */

        $salesData = Sale::find()
            ->select([
                "DATE(created_at) as date",
                "SUM(total_amount) as total",
            ])
            ->where(['branch_id' => $branchIds])
            ->groupBy(["DATE(created_at)"])
            ->orderBy(['date' => SORT_ASC])
            ->asArray()
            ->all();

        /**
         * ============================
         * PROFIT CHART DATA
         * ============================
         */

        $profitData = Sale::find()
            ->select([
                "DATE(created_at) as date",
                "SUM(total_profit) as total",
            ])
            ->where(['branch_id' => $branchIds])
            ->groupBy(["DATE(created_at)"])
            ->orderBy(['date' => SORT_ASC])
            ->asArray()
            ->all();

        /**
         * ============================
         * RENDER VIEW
         * ============================
         */

        return $this->render('index', [

            'businesses' => $businesses,

            'branches' => $branches,

            'totalSales' => $totalSales ?? 0,

            'totalProfit' => $totalProfit ?? 0,

            'totalPurchases' => $totalPurchases ?? 0,

            'totalProducts' => $totalProducts ?? 0,

            'lowStock' => $lowStock ?? 0,

            'totalSellers' => $totalSellers ?? 0,

            'recentProducts' => $recentProducts,

            'salesData' => $salesData,

            'profitData' => $profitData,
        ]);
    }
}
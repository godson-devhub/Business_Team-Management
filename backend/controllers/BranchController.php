<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;

use common\models\Branch;
use common\models\Business;
use common\models\User;
use common\models\Product;
use common\models\Sale;
use common\models\Purchase;
use common\models\StockMovement;
use common\models\SaleItem;
use common\models\PurchaseItem;

class BranchController extends Controller
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

                            return Yii::$app
                                ->user
                                ->identity
                                ->role === 'owner';
                        }
                    ],
                ],
            ],
        ];
    }

    /* =========================
     * INDEX
     * ========================= */
    public function actionIndex()
    {
        $branches = Branch::find()

            ->alias('b')

            ->joinWith(['business bs'])

            ->where([
                'bs.owner_id' => Yii::$app->user->id
            ])

            ->orderBy([
                'b.id' => SORT_DESC
            ])

            ->all();

        return $this->render('index', [

            'branches' => $branches

        ]);
    }

    /* =========================
     * VIEW (BRANCH DASHBOARD)
     * ========================= */
    public function actionView($id)
    {
        $model = $this->findModel($id);

        /* =========================
         * SELLERS
         * ========================= */
        $sellers = User::find()

            ->where([
                'branch_id' => $id
            ])

            ->all();

        /* =========================
         * PRODUCTS
         * ========================= */
        $products = Product::find()

            ->where([
                'branch_id' => $id
            ])

            ->all();

        /* =========================
         * SALES
         * ========================= */
        $sales = Sale::find()

            ->where([
                'branch_id' => $id
            ])

            ->orderBy([
                'id' => SORT_DESC
            ])

            ->limit(10)

            ->all();

        /* =========================
         * PURCHASES
         * ========================= */
        $purchases = Purchase::find()

            ->where([
                'branch_id' => $id
            ])

            ->orderBy([
                'id' => SORT_DESC
            ])

            ->limit(10)

            ->all();

        /* =========================
         * TODAY
         * ========================= */
        $startToday = strtotime('today');
        $endToday   = strtotime('tomorrow');

        /* =========================
         * DAILY SALES
         * ========================= */
        $dailySales = (float) Sale::find()

            ->where([
                'branch_id' => $id
            ])

            ->andWhere([
                'between',
                'created_at',
                $startToday,
                $endToday
            ])

            ->sum('total_amount');

        /* =========================
         * DAILY PROFIT
         * ========================= */
        $dailyProfit = (float) Sale::find()

            ->where([
                'branch_id' => $id
            ])

            ->andWhere([
                'between',
                'created_at',
                $startToday,
                $endToday
            ])

            ->sum('total_profit');

        /* =========================
         * STOCK VALUE
         * ========================= */
        $stockValue = 0;

        foreach ($products as $product) {

            $stockValue += (

                $product->stock_quantity *
                $product->selling_price
            );
        }

        /* =========================
         * LOW STOCK
         * ========================= */
        $lowStock = Product::find()

            ->where([
                'branch_id' => $id
            ])

            ->andWhere([
                '<=',
                'stock_quantity',
                5
            ])

            ->count();

        /* =========================
         * STOCK MOVEMENTS
         * ========================= */
        $stockMovements = StockMovement::find()

            ->where([
                'branch_id' => $id
            ])

            ->orderBy([
                'id' => SORT_DESC
            ])

            ->limit(15)

            ->all();

        return $this->render('view', [

            'branch' => $model,

            'sellers' => $sellers,

            'products' => $products,

            'sales' => $sales,

            'purchases' => $purchases,

            'dailySales' => $dailySales,

            'dailyProfit' => $dailyProfit,

            'stockValue' => $stockValue,

            'lowStock' => $lowStock,

            'stockMovements' => $stockMovements,
        ]);
    }

    /* =========================
     * CREATE
     * ========================= */
    public function actionCreate()
    {
        $model = new Branch();

        $businesses = Business::find()

            ->where([
                'owner_id' => Yii::$app->user->id
            ])

            ->all();

        if ($model->load(Yii::$app->request->post())) {

            $business = Business::findOne([

                'id' => $model->business_id,

                'owner_id' => Yii::$app->user->id
            ]);

            if (!$business) {

                throw new NotFoundHttpException(
                    'Invalid business selected.'
                );
            }

            if ($model->save()) {

                Yii::$app->session->setFlash(
                    'success',
                    'Branch created successfully!'
                );

                return $this->redirect(['index']);
            }
        }

        return $this->render('create', [

            'model' => $model,

            'businesses' => $businesses
        ]);
    }

    /* =========================
     * UPDATE
     * ========================= */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $businesses = Business::find()

            ->where([
                'owner_id' => Yii::$app->user->id
            ])

            ->all();

        if (
            $model->load(Yii::$app->request->post())
            && $model->save()
        ) {

            Yii::$app->session->setFlash(
                'success',
                'Branch updated!'
            );

            return $this->redirect(['index']);
        }

        return $this->render('update', [

            'model' => $model,

            'businesses' => $businesses
        ]);
    }

    /* =========================
     * DELETE
     * ========================= */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        Yii::$app->session->setFlash(
            'success',
            'Branch deleted!'
        );

        return $this->redirect(['index']);
    }


    /* =========================
 * SELLERS PAGE
 * ========================= */
    public function actionSellers($id)
    {
        $branch = $this->findModel($id);

        $sellers = User::find()
            ->where(['branch_id' => $id])
            ->orderBy(['id' => SORT_DESC])
            ->all();

        return $this->render('sellers', [
            'branch' => $branch,
            'sellers' => $sellers,
        ]);
    }

/* =========================
 * PRODUCTS PAGE
 * ========================= */
    public function actionProducts($id)
    {
        $branch = $this->findModel($id);

        $products = Product::find()
            ->where(['branch_id' => $id])
            ->orderBy(['name' => SORT_ASC])
            ->all();

        return $this->render('products', [
            'branch' => $branch,
            'products' => $products,
        ]);
    }

/* =========================
 * LOW STOCK PAGE
 * ========================= */
   public function actionLowStock($id)
   {
        $branch = $this->findModel($id);

        $products = Product::find()
            ->where(['branch_id' => $id])
            ->andWhere(['<=', 'stock_quantity', 5])
            ->orderBy(['stock_quantity' => SORT_ASC])
            ->all();

        return $this->render('low-stock', [
            'branch' => $branch,
            'products' => $products,
        ]);
    }

/* =========================
 * PURCHASES PAGE
 * ========================= */
   public function actionPurchases($id)
   {
        $branch = $this->findModel($id);

        $purchases = PurchaseItem::find()
            ->alias('pi')
            ->innerJoin('purchase p', 'p.id = pi.purchase_id')
            ->innerJoin('product pr', 'pr.id = pi.product_id')
            ->where(['p.branch_id' => $id])
            ->orderBy(['p.id' => SORT_DESC])
            ->all();

        return $this->render('purchases', [
            'branch' => $branch,
            'purchases' => $purchases,
        ]);
    }
    

    /* =========================
 * DAILY SALES PAGE
 * ========================= */
    public function actionDailySales($id)
    {
        $branch = $this->findModel($id);

        $startToday = strtotime('today');
        $endToday   = strtotime('tomorrow');

        $sales = SaleItem::find()
            ->alias('si')

            ->innerJoin(
                'sale s',
                's.id = si.sale_id'
            )

            ->where([
               's.branch_id' => $id
            ])

            ->andWhere([
               'between',
               's.created_at',
               $startToday,
               $endToday
            ])

            ->orderBy([
                'si.id' => SORT_DESC
            ])

            ->all();

        return $this->render('daily-sales', [
            'branch' => $branch,
            'sales' => $sales,
        ]);
    }
    

    /* =========================
 * DAILY PROFIT PAGE
 * ========================= */
    public function actionDailyProfit($id)
    {
        $branch = $this->findModel($id);

        $startToday = strtotime('today');
        $endToday   = strtotime('tomorrow');

        $sales = SaleItem::find()
            ->alias('si')

            ->innerJoin(
                'sale s',
                's.id = si.sale_id'
            )

            ->where([
                's.branch_id' => $id
            ])

            ->andWhere([
                'between',
                's.created_at',
                $startToday,
                $endToday
            ])

            ->orderBy([
                'si.id' => SORT_DESC
            ])

            ->all();

        $totalProfit = SaleItem::find()
            ->alias('si')

            ->innerJoin(
                'sale s',
                's.id = si.sale_id'
            )

            ->where([
                's.branch_id' => $id
           ])

            ->andWhere([
                'between',
                's.created_at',
                $startToday,
                $endToday
            ])

            ->sum('si.profit');

        return $this->render('daily-profit', [
            'branch' => $branch,
            'sales' => $sales,
            'totalProfit' => $totalProfit,
        ]);
    }



/* =========================
 * STOCK VALUE PAGE
 * ========================= */
    public function actionStockValue($id)
    {
        $branch = $this->findModel($id);

        $products = Product::find()
            ->where(['branch_id' => $id])
            ->orderBy(['name' => SORT_ASC])
            ->all();

        $stockValue = 0;

        foreach ($products as $product) {
            $stockValue += (
                $product->stock_quantity *
                $product->selling_price
            );
        }

        return $this->render('stock-value', [
            'branch' => $branch,
            'products' => $products,
            'stockValue' => $stockValue,
        ]);
    }  

    /* =========================
     * FIND MODEL
     * ========================= */
    protected function findModel($id)
    {
        $model = Branch::find()

            ->alias('b')

            ->joinWith(['business bs'])

            ->where([

                'b.id' => $id,

                'bs.owner_id' => Yii::$app->user->id
            ])

            ->one();

        if ($model !== null) {

            return $model;
        }

        throw new NotFoundHttpException(
            'Branch not found or access denied.'
        );
    }
}

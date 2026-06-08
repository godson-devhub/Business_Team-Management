<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use yii\filters\AccessControl;

use common\models\Product;
use common\models\Sale;
use common\models\Purchase;

class SellerController extends Controller
{
    /**
     * =========================
     * ACCESS CONTROL
     * =========================
     */
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
     * =========================
     * GLOBAL SAFETY CHECK
     * =========================
     */
    public function beforeAction($action)
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['/site/login']);
        }

        if (Yii::$app->user->identity->role !== 'seller') {
            throw new ForbiddenHttpException('Access denied. Seller only area.');
        }

        return parent::beforeAction($action);
    }

    /**
     * =========================
     * INDEX
     * =========================
     */
    public function actionIndex()
    {
        return $this->redirect(['dashboard']);
    }

    /**
     * =========================
     * DASHBOARD
     * =========================
     */
    public function actionDashboard()
    {
        $seller = Yii::$app->user->identity;
        $branchId = $seller->branch_id;

        if (!$branchId) {
            throw new ForbiddenHttpException("No branch assigned to this seller.");
        }

        return $this->render('dashboard', [
            'totalProducts' => Product::find()->where(['branch_id' => $branchId])->count(),

            'todaySales' => (float) Sale::find()
                ->where(['branch_id' => $branchId])
                ->andWhere(['DATE(created_at)' => date('Y-m-d')])
                ->sum('total_amount'),

            'todayProfit' => (float) Sale::find()
                ->where(['branch_id' => $branchId])
                ->andWhere(['DATE(created_at)' => date('Y-m-d')])
                ->sum('total_profit'),

            'lowStock' => Product::find()
                ->where(['branch_id' => $branchId])
                ->andWhere(['<=', 'stock_quantity', 5])
                ->count(),

            'recentProducts' => Product::find()
                ->where(['branch_id' => $branchId])
                ->orderBy(['id' => SORT_DESC])
                ->limit(5)
                ->all(),
        ]);
    }

    /**
     * =========================
     * PRODUCTS LIST
     * =========================
     */
    public function actionProducts()
    {
        $seller = Yii::$app->user->identity;

        $products = Product::find()
            ->where(['branch_id' => $seller->branch_id])
            ->orderBy(['id' => SORT_DESC])
            ->all();

        return $this->render('products/index', [
            'products' => $products
        ]);
    }

    /**
     * =========================
     * CREATE PRODUCT
     * =========================
     */
    public function actionCreateProduct()
    {
        $seller = Yii::$app->user->identity;

        $model = new Product();

        if ($model->load(Yii::$app->request->post())) {

            $model->branch_id = $seller->branch_id;
            $model->created_by = $seller->id;
            $model->status = 1;

            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Product created successfully');
                return $this->redirect(['products']);
            }
        }

        return $this->render('products/create', [
            'model' => $model
        ]);
    }

    /**
     * =========================
     * UPDATE PRODUCT
     * =========================
     */
    public function actionUpdateProduct($id)
    {
        $seller = Yii::$app->user->identity;

        $model = Product::find()
            ->where([
                'id' => $id,
                'branch_id' => $seller->branch_id
            ])
            ->one();

        if (!$model) {
            throw new NotFoundHttpException("Product not found");
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Product updated successfully');
            return $this->redirect(['products']);
        }

        return $this->render('products/update', [
            'model' => $model
        ]);
    }

    /**
     * =========================
     * DELETE PRODUCT
     * =========================
     */
    public function actionDeleteProduct($id)
    {
        $seller = Yii::$app->user->identity;

        $model = Product::find()
            ->where([
                'id' => $id,
                'branch_id' => $seller->branch_id
            ])
            ->one();

        if ($model) {
            $model->delete();
        }

        return $this->redirect(['products']);
    }
}
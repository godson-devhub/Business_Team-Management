<?php

declare(strict_types=1);

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use yii\filters\AccessControl;

use common\models\Product;

class ProductController extends Controller
{
    /**
     * =========================
     * ACCESS CONTROL (SELLER ONLY)
     * =========================
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
                                && Yii::$app->user->identity->role === 'seller';
                        }
                    ],
                ],
            ],
        ];
    }

    /**
     * =========================
     * LIST PRODUCTS
     * =========================
     */
    public function actionIndex()
    {
        $user = Yii::$app->user->identity;

        if (!$user->branch_id) {
            throw new ForbiddenHttpException("No branch assigned.");
        }

        $products = Product::find()
            ->where(['branch_id' => $user->branch_id])
            ->orderBy(['id' => SORT_DESC])
            ->all();

        return $this->render('index', [
            'products' => $products
        ]);
    }

    /**
     * =========================
     * CREATE PRODUCT (FIXED CSRF SAFE)
     * =========================
     */
    public function actionCreate()
    {
        $user = Yii::$app->user->identity;

        if (!$user->branch_id) {
            throw new ForbiddenHttpException("No branch assigned.");
        }

        $model = new Product();

        // DEFAULT VALUES (important for DB NOT NULL fields)
        $model->stock_quantity = 0;
        $model->min_stock_alert = 5;
        $model->status = 1;

        if ($model->load(Yii::$app->request->post())) {

            $model->branch_id = $user->branch_id;
            $model->created_by = $user->id;

            // AUTO SKU IF EMPTY
            if (empty($model->sku)) {
                $model->sku = 'SKU-' . time();
            }

            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Product created successfully');
                return $this->redirect(['index']);
            }
        }

        return $this->render('create', [
            'model' => $model
        ]);
    }

    /**
     * =========================
     * UPDATE PRODUCT
     * =========================
     */
    public function actionUpdate(int $id)
    {
        $user = Yii::$app->user->identity;

        $model = Product::find()
            ->where([
                'id' => $id,
                'branch_id' => $user->branch_id
            ])
            ->one();

        if (!$model) {
            throw new NotFoundHttpException("Product not found.");
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            Yii::$app->session->setFlash('success', 'Product updated successfully');
            return $this->redirect(['index']);
        }

        return $this->render('update', [
            'model' => $model
        ]);
    }

    /**
     * =========================
     * DELETE PRODUCT
     * =========================
     */
    public function actionDelete(int $id)
    {
        $user = Yii::$app->user->identity;

        $model = Product::find()
            ->where([
                'id' => $id,
                'branch_id' => $user->branch_id
            ])
            ->one();

        if (!$model) {
            throw new NotFoundHttpException("Product not found.");
        }

        $model->delete();

        Yii::$app->session->setFlash('success', 'Product deleted successfully');

        return $this->redirect(['index']);
    }
}
<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use common\models\Product;

class ProductController extends Controller
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
                            return Yii::$app->user->identity->role === 'seller';
                        }
                    ],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $user = Yii::$app->user->identity;

        $products = Product::find()
            ->where(['branch_id' => $user->branch_id])
            ->all();

        return $this->render('index', [
            'products' => $products
        ]);
    }

    public function actionCreate()
    {
        $model = new Product();
        $user = Yii::$app->user->identity;

        if ($model->load(Yii::$app->request->post())) {

            $model->branch_id = $user->branch_id;
            $model->created_by = $user->id;

            if ($model->save()) {
                return $this->redirect(['index']);
            }
        }

        return $this->render('create', ['model' => $model]);
    }

    public function actionUpdate($id)
    {
        $model = Product::findOne($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }

        return $this->render('update', ['model' => $model]);
    }

    public function actionDelete($id)
    {
        Product::findOne($id)?->delete();
        return $this->redirect(['index']);
    }
}
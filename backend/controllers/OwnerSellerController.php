<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;

use common\models\User;
use common\models\Branch;

class OwnerSellerController extends Controller
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
                            return Yii::$app->user->identity->role === 'owner';
                        }
                    ],
                ],
            ],
        ];
    }

    /* =========================
     * LIST SELLERS
     * ========================= */
    public function actionIndex()
    {
        $sellers = User::find()
            ->where(['role' => 'seller'])
            ->all();

        return $this->render('index', [
            'sellers' => $sellers
        ]);
    }

    /* =========================
     * CREATE SELLER
     * ========================= */
    public function actionCreate()
    {
        $model = new User();
        $branches = Branch::find()->all();

        if ($model->load(Yii::$app->request->post())) {

            $model->role = 'seller';
            $model->status = 10;

            if ($model->password) {
                $model->setPassword($model->password);
            }
            $model->generateAuthKey();

            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Seller created!');
                return $this->redirect(['index']);
            }
        }

        return $this->render('create', [
            'model' => $model,
            'branches' => $branches
        ]);
    }

    /* =========================
     * UPDATE SELLER (ASSIGN BRANCH)
     * ========================= */
    public function actionUpdate($id)
    {
        $model = User::findOne($id);

        if (!$model || $model->role !== 'seller') {
            throw new NotFoundHttpException("Seller not found");
        }

        $branches = Branch::find()->all();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Seller updated!');
            return $this->redirect(['index']);
        }

        return $this->render('update', [
            'model' => $model,
            'branches' => $branches
        ]);
    }

    /* =========================
     * DELETE SELLER
     * ========================= */
    public function actionDelete($id)
    {
        $model = User::findOne($id);

        if ($model && $model->role === 'seller') {
            $model->delete();
        }

        return $this->redirect(['index']);
    }
}
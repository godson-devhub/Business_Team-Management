<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;
use common\models\Business;

class BusinessController extends Controller
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
     * LIST BUSINESSES
     * ========================= */
    public function actionIndex()
    {
        $businesses = Business::find()
            ->where(['owner_id' => Yii::$app->user->id])
            ->orderBy(['id' => SORT_DESC])
            ->all();

        return $this->render('index', [
            'businesses' => $businesses
        ]);
    }

    /* =========================
     * CREATE BUSINESS
     * ========================= */
    public function actionCreate()
    {
        $model = new Business();

        if ($model->load(Yii::$app->request->post())) {

            $model->owner_id = Yii::$app->user->id;
            $model->status = 1;

            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Business created successfully!');
                return $this->redirect(['index']);
            }
        }

        return $this->render('create', [
            'model' => $model
        ]);
    }

    /* =========================
     * UPDATE BUSINESS
     * ========================= */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Business updated successfully!');
            return $this->redirect(['index']);
        }

        return $this->render('update', [
            'model' => $model
        ]);
    }

    /* =========================
     * DELETE BUSINESS
     * ========================= */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->delete();

        Yii::$app->session->setFlash('success', 'Business deleted!');
        return $this->redirect(['index']);
    }

    /* =========================
     * FIND MODEL
     * ========================= */
    protected function findModel($id)
    {
        if (($model = Business::findOne([
            'id' => $id,
            'owner_id' => Yii::$app->user->id
        ])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Business not found.');
    }
}
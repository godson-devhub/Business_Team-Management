<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;
use common\models\Branch;
use common\models\Business;

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
                            return Yii::$app->user->identity->role === 'owner';
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
            ->where(['bs.owner_id' => Yii::$app->user->id])
            ->orderBy(['b.id' => SORT_DESC])
            ->all();

        return $this->render('index', [
            'branches' => $branches
        ]);
    }

    /* =========================
     * CREATE
     * ========================= */
    public function actionCreate()
    {
        $model = new Branch();

        $businesses = Business::find()
            ->where(['owner_id' => Yii::$app->user->id])
            ->all();

        if ($model->load(Yii::$app->request->post())) {

            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Branch created successfully!');
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
            ->where(['owner_id' => Yii::$app->user->id])
            ->all();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Branch updated!');
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

        Yii::$app->session->setFlash('success', 'Branch deleted!');
        return $this->redirect(['index']);
    }

    /* =========================
     * FIND MODEL
     * ========================= */
    protected function findModel($id)
    {
        if (($model = Branch::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Branch not found');
    }
}
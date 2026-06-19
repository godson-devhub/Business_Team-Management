<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;

use common\models\User;
use common\models\Branch;
use common\components\RbacHelper;

class OwnerSellerController extends Controller
{
    /**
     * =========================
     * ACCESS CONTROL (OWNER ONLY)
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
                            return RbacHelper::isOwner(Yii::$app->user->identity);
                        }
                    ],
                ],
            ],
        ];
    }

    /**
     * =========================
     * LIST SELLERS
     * =========================
     */
    public function actionIndex()
    {
        $this->checkOwner();

        $sellers = User::find()
            ->where(['role' => 'seller'])
            ->orderBy(['id' => SORT_DESC])
            ->all();

        return $this->render('index', [
            'sellers' => $sellers
        ]);
    }

    /**
     * =========================
     * CREATE SELLER
     * =========================
     */
    public function actionCreate()
    {
        $this->checkOwner();

        $model = new User();
        $branches = Branch::find()->orderBy(['name' => SORT_ASC])->all();

        if ($model->load(Yii::$app->request->post())) {

            // FORCE ROLE
            $model->role = 'seller';
            $model->status = 10;

            // PASSWORD HANDLING (IMPORTANT FIX)
            if (!empty($model->password)) {
                $model->setPassword($model->password);
            } else {
                $model->addError('password', 'Password is required');
                return $this->render('create', [
                    'model' => $model,
                    'branches' => $branches
                ]);
            }

            $model->generateAuthKey();

            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Seller created successfully');
                return $this->redirect(['index']);
            }
        }

        return $this->render('create', [
            'model' => $model,
            'branches' => $branches
        ]);
    }

    /**
     * =========================
     * UPDATE SELLER
     * =========================
     */
    public function actionUpdate($id)
    {
        $this->checkOwner();

        $model = User::findOne($id);

        if (!$model || $model->role !== 'seller') {
            throw new NotFoundHttpException("Seller not found");
        }

        $branches = Branch::find()->orderBy(['name' => SORT_ASC])->all();

        $oldPassword = $model->password_hash;

        if ($model->load(Yii::$app->request->post())) {

            // DO NOT overwrite password unless provided
            if (!empty($model->password)) {
                $model->setPassword($model->password);
            } else {
                $model->password_hash = $oldPassword;
            }

            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Seller updated successfully');
                return $this->redirect(['index']);
            }
        }

        return $this->render('update', [
            'model' => $model,
            'branches' => $branches
        ]);
    }

    /**
     * =========================
     * DELETE SELLER
     * =========================
     */
    public function actionDelete($id)
    {
        $this->checkOwner();

        $model = User::findOne($id);

        if (!$model || $model->role !== 'seller') {
            throw new NotFoundHttpException("Seller not found");
        }

        $model->delete();

        Yii::$app->session->setFlash('success', 'Seller deleted successfully');

        return $this->redirect(['index']);
    }

    /**
     * =========================
     * CENTRAL OWNER CHECK
     * =========================
     */
    private function checkOwner()
    {
        if (Yii::$app->user->isGuest) {
            throw new ForbiddenHttpException("Login required");
        }

        if (!RbacHelper::isOwner(Yii::$app->user->identity)) {
            throw new ForbiddenHttpException("Only owner can access this section");
        }
    }
}
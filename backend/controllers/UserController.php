<?php

declare(strict_types=1);

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;

use common\models\User;
use common\models\Branch;

class UserController extends Controller
{
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
        $ownerId = Yii::$app->user->id;

        $sellers = User::find()
            ->alias('u')
            ->innerJoin('branch b', 'b.id = u.branch_id')
            ->innerJoin('business bs', 'bs.id = b.business_id')
            ->where([
                'bs.owner_id' => $ownerId,
                'u.role' => User::ROLE_SELLER
            ])
            ->orderBy(['u.id' => SORT_DESC])
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

        $branches = Branch::find()
            ->innerJoin('business b', 'b.id = branch.business_id')
            ->where(['b.owner_id' => Yii::$app->user->id])
            ->all();

        if ($model->load(Yii::$app->request->post())) {

            $model->role = User::ROLE_SELLER;
            $model->status = User::STATUS_ACTIVE;

            // set password manually by owner
            if (!empty($model->password)) {
                $model->setPassword($model->password);
                $model->generateAuthKey();
            }

            if ($model->save()) {

                Yii::$app->session->setFlash(
                    'success',
                    'Seller created successfully'
                );

                return $this->redirect(['index']);
            }
        }

        return $this->render('create', [
            'model' => $model,
            'branches' => $branches
        ]);
    }

    /* =========================
     * UPDATE SELLER
     * ========================= */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {

            // update password only if provided
            if (!empty($model->password)) {
                $model->setPassword($model->password);
                $model->generateAuthKey();
            }

            if ($model->save()) {

                Yii::$app->session->setFlash(
                    'success',
                    'Seller updated successfully'
                );

                return $this->redirect(['index']);
            }
        }

        return $this->render('update', [
            'model' => $model
        ]);
    }

    /* =========================
     * DELETE SELLER
     * ========================= */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        $model->delete();

        Yii::$app->session->setFlash(
            'success',
            'Seller deleted successfully'
        );

        return $this->redirect(['index']);
    }

    /* =========================
     * FIND MODEL
     * ========================= */
    protected function findModel($id): User
    {
        $model = User::find()
            ->alias('u')
            ->innerJoin('branch b', 'b.id = u.branch_id')
            ->innerJoin('business bs', 'bs.id = b.business_id')
            ->where([
                'u.id' => $id,
                'bs.owner_id' => Yii::$app->user->id,
                'u.role' => User::ROLE_SELLER
            ])
            ->one();

        if (!$model) {
            throw new NotFoundHttpException('Seller not found.');
        }

        return $model;
    }
}
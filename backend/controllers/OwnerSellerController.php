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
    /* =========================
     * ACCESS CONTROL (OWNER ONLY)
     * ========================= */
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

    /* =========================
     * LIST SELLERS (FILTERED VIA BRANCH → BUSINESS)
     * ========================= */
    public function actionIndex()
    {
        $this->checkOwner();

        $ownerId = Yii::$app->user->id;

        $sellers = User::find()
            ->alias('u')
            ->innerJoin('branch b', 'b.id = u.branch_id')
            ->innerJoin('business bs', 'bs.id = b.business_id')
            ->where([
                'u.role' => 'seller',
                'bs.owner_id' => $ownerId
            ])
            ->orderBy(['u.id' => SORT_DESC])
            ->all();

        return $this->render('index', [
            'sellers' => $sellers
        ]);
    }

    /* =========================
     * CREATE SELLER (ASSIGN BRANCH SAFELY)
     * ========================= */
    public function actionCreate()
    {
        $this->checkOwner();

        $model = new User();

        // ONLY branches belonging to this owner
        $branches = Branch::find()
            ->alias('b')
            ->innerJoin('business bs', 'bs.id = b.business_id')
            ->where(['bs.owner_id' => Yii::$app->user->id])
            ->orderBy(['b.name' => SORT_ASC])
            ->all();

        if ($model->load(Yii::$app->request->post())) {

            $model->role = 'seller';
            $model->status = 10;

            // SECURITY: ensure branch belongs to this owner
            $branch = Branch::find()
                ->alias('b')
                ->innerJoin('business bs', 'bs.id = b.business_id')
                ->where([
                    'b.id' => $model->branch_id,
                    'bs.owner_id' => Yii::$app->user->id
                ])
                ->one();

            if (!$branch) {
                throw new ForbiddenHttpException("Invalid branch selected");
            }

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

    /* =========================
     * UPDATE SELLER (SECURE OWNERSHIP CHECK)
     * ========================= */
    public function actionUpdate($id)
    {
        $this->checkOwner();

        $model = User::find()
            ->alias('u')
            ->innerJoin('branch b', 'b.id = u.branch_id')
            ->innerJoin('business bs', 'bs.id = b.business_id')
            ->where([
                'u.id' => $id,
                'u.role' => 'seller',
                'bs.owner_id' => Yii::$app->user->id
            ])
            ->one();

        if (!$model) {
            throw new NotFoundHttpException("Seller not found");
        }

        $branches = Branch::find()
            ->alias('b')
            ->innerJoin('business bs', 'bs.id = b.business_id')
            ->where(['bs.owner_id' => Yii::$app->user->id])
            ->orderBy(['b.name' => SORT_ASC])
            ->all();

        $oldPassword = $model->password_hash;

        if ($model->load(Yii::$app->request->post())) {

            // re-check branch ownership
            $branch = Branch::find()
                ->alias('b')
                ->innerJoin('business bs', 'bs.id = b.business_id')
                ->where([
                    'b.id' => $model->branch_id,
                    'bs.owner_id' => Yii::$app->user->id
                ])
                ->one();

            if (!$branch) {
                throw new ForbiddenHttpException("Invalid branch selected");
            }

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

    /* =========================
     * DELETE SELLER (SECURE)
     * ========================= */
    public function actionDelete($id)
    {
        $this->checkOwner();

        $model = User::find()
            ->alias('u')
            ->innerJoin('branch b', 'b.id = u.branch_id')
            ->innerJoin('business bs', 'bs.id = b.business_id')
            ->where([
                'u.id' => $id,
                'u.role' => 'seller',
                'bs.owner_id' => Yii::$app->user->id
            ])
            ->one();

        if (!$model) {
            throw new NotFoundHttpException("Seller not found");
        }

        $model->delete();

        Yii::$app->session->setFlash('success', 'Seller deleted successfully');

        return $this->redirect(['index']);
    }

    /* =========================
     * OWNER CHECK
     * ========================= */
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
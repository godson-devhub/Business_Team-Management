<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use yii\filters\VerbFilter;

use common\models\Product;
use common\models\Branch;

class OwnerProductController extends Controller
{
    /* =========================
     BEHAVIORS
    ========================= */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /* =========================
     INDEX (FILTERED BRANCHES + PRODUCTS)
    ========================= */
    public function actionIndex($branch_id = null)
    {
        $ownerId = Yii::$app->user->id;

        // 🔥 ONLY BRANCHES BELONGING TO OWNER
        $branches = Branch::find()
            ->alias('b')
            ->innerJoin('business bs', 'bs.id = b.business_id')
            ->where(['bs.owner_id' => $ownerId])
            ->orderBy(['b.name' => SORT_ASC])
            ->all();

        // validate selected branch belongs to owner
        if ($branch_id) {
            $validBranch = Branch::find()
                ->alias('b')
                ->innerJoin('business bs', 'bs.id = b.business_id')
                ->where([
                    'b.id' => $branch_id,
                    'bs.owner_id' => $ownerId
                ])
                ->one();

            if (!$validBranch) {
                throw new ForbiddenHttpException('Invalid branch selected');
            }

            Yii::$app->session->set('active_branch_id', $branch_id);
        }

        $activeBranch = Yii::$app->session->get('active_branch_id');

        $products = [];

        if ($activeBranch) {

            $products = Product::find()
                ->where(['branch_id' => $activeBranch])
                ->orderBy(['id' => SORT_DESC])
                ->all();
        }

        return $this->render('index', [
            'branches'     => $branches,
            'activeBranch' => $activeBranch,
            'products'     => $products,
        ]);
    }

    /* =========================
     CREATE PRODUCT
    ========================= */
    public function actionCreate()
    {
        if (Yii::$app->user->isGuest) {
            throw new ForbiddenHttpException('Login required.');
        }

        $branchId = Yii::$app->session->get('active_branch_id');
        $ownerId  = Yii::$app->user->id;

        if (!$branchId) {
            Yii::$app->session->setFlash('error', 'Please select a branch first.');
            return $this->redirect(['index']);
        }

        // 🔥 VALIDATE BRANCH OWNERSHIP
        $branch = Branch::find()
            ->alias('b')
            ->innerJoin('business bs', 'bs.id = b.business_id')
            ->where([
                'b.id' => $branchId,
                'bs.owner_id' => $ownerId
            ])
            ->one();

        if (!$branch) {
            throw new ForbiddenHttpException('Invalid branch access.');
        }

        $model = new Product();
        $model->branch_id = $branchId;

        if ($model->load(Yii::$app->request->post())) {

            $model->created_by = Yii::$app->user->id;

            if ($model->save()) {

                Yii::$app->session->setFlash('success', 'Product created successfully.');

                return $this->redirect([
                    'index',
                    'branch_id' => $branchId
                ]);
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /* =========================
     UPDATE PRODUCT
    ========================= */
    public function actionUpdate($id)
    {
        if (Yii::$app->user->isGuest) {
            throw new ForbiddenHttpException('Login required.');
        }

        $ownerId = Yii::$app->user->id;

        $model = Product::findOne($id);

        if (!$model) {
            throw new NotFoundHttpException('Product not found.');
        }

        // 🔥 VALIDATE PRODUCT OWNERSHIP VIA BRANCH → BUSINESS
        $valid = Branch::find()
            ->alias('b')
            ->innerJoin('business bs', 'bs.id = b.business_id')
            ->where([
                'b.id' => $model->branch_id,
                'bs.owner_id' => $ownerId
            ])
            ->one();

        if (!$valid) {
            throw new ForbiddenHttpException('Access denied.');
        }

        if ($model->load(Yii::$app->request->post())) {

            if ($model->save()) {

                Yii::$app->session->setFlash('success', 'Product updated successfully.');

                return $this->redirect([
                    'index',
                    'branch_id' => $model->branch_id
                ]);
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /* =========================
     DELETE PRODUCT
    ========================= */
    public function actionDelete($id)
    {
        if (Yii::$app->user->isGuest) {
            throw new ForbiddenHttpException('Login required.');
        }

        $ownerId = Yii::$app->user->id;

        $model = Product::findOne($id);

        if (!$model) {
            throw new NotFoundHttpException('Product not found.');
        }

        // 🔥 VALIDATE OWNERSHIP
        $valid = Branch::find()
            ->alias('b')
            ->innerJoin('business bs', 'bs.id = b.business_id')
            ->where([
                'b.id' => $model->branch_id,
                'bs.owner_id' => $ownerId
            ])
            ->one();

        if (!$valid) {
            throw new ForbiddenHttpException('Access denied.');
        }

        $redirectBranch = $model->branch_id;

        $model->delete();

        Yii::$app->session->setFlash('success', 'Product deleted successfully.');

        return $this->redirect([
            'index',
            'branch_id' => $redirectBranch
        ]);
    }
}
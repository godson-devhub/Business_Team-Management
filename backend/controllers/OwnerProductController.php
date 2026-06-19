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
     BEHAVIORS (SECURE DELETE)
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
     INDEX (SELECT BRANCH + LIST PRODUCTS)
    ========================= */
    public function actionIndex($branch_id = null)
    {
        $branches = Branch::find()
            ->orderBy(['name' => SORT_ASC])
            ->all();

        // set selected branch
        if ($branch_id) {
            Yii::$app->session->set('active_branch_id', $branch_id);
        }

        $activeBranch = Yii::$app->session->get('active_branch_id');

        $products = [];

        if ($activeBranch) {

            $branch = Branch::findOne($activeBranch);

            // validate branch exists
            if (!$branch) {
                Yii::$app->session->remove('active_branch_id');
                $activeBranch = null;
            } else {
                $products = Product::find()
                    ->where(['branch_id' => $activeBranch])
                    ->orderBy(['id' => SORT_DESC])
                    ->all();
            }
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

        if (!$branchId) {
            Yii::$app->session->setFlash('error', 'Please select a branch first.');
            return $this->redirect(['index']);
        }

        $model = new Product();

        // IMPORTANT: assign branch BEFORE load/save
        $model->branch_id = $branchId;

        if ($model->load(Yii::$app->request->post())) {

            // FIX: created_by foreign key error
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

        $model = Product::findOne($id);

        if (!$model) {
            throw new NotFoundHttpException('Product not found.');
        }

        $branchId = Yii::$app->session->get('active_branch_id');

        // ensure user is working in same branch
        if ($branchId && $model->branch_id != $branchId) {
            throw new ForbiddenHttpException('Access denied for this branch.');
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

        $model = Product::findOne($id);

        if (!$model) {
            throw new NotFoundHttpException('Product not found.');
        }

        $branchId = Yii::$app->session->get('active_branch_id');

        if ($branchId && $model->branch_id != $branchId) {
            throw new ForbiddenHttpException('Access denied for this branch.');
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
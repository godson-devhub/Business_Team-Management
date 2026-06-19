<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\web\ForbiddenHttpException;

use common\models\Product;
use common\models\Sale;
use common\models\SaleItem;
use common\services\StockService;

class SaleController extends Controller
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
                            return Yii::$app->user->identity
                                && Yii::$app->user->identity->role === 'seller';
                        }
                    ],
                ],
            ],
        ];
    }

    // =========================
    // INDEX
    // =========================
    public function actionIndex()
    {
        $user = Yii::$app->user->identity;

        $sales = Sale::find()
            ->where(['branch_id' => $user->branch_id])
            ->orderBy(['id' => SORT_DESC])
            ->all();

        return $this->render('index', [
            'sales' => $sales
        ]);
    }

    // =========================
    // CREATE SALE (FIXED 100%)
    // =========================
    public function actionCreate()
    {
        $user = Yii::$app->user->identity;

        if (!$user || !$user->branch_id) {
            throw new ForbiddenHttpException('No branch assigned.');
        }

        $products = Product::find()
            ->where(['branch_id' => $user->branch_id])
            ->all();

        if (!Yii::$app->request->isPost) {
            return $this->render('create', [
                'products' => $products
            ]);
        }

        // =========================
        // SAFE INPUT
        // =========================
        $productId = (int) Yii::$app->request->post('product_id');
        $quantity  = (int) Yii::$app->request->post('quantity');

        if ($productId <= 0 || $quantity <= 0) {
            Yii::$app->session->setFlash('error', 'Invalid input.');
            return $this->refresh();
        }

        // =========================
        // PRODUCT (branch-safe)
        // =========================
        $product = Product::find()
            ->where([
                'id' => $productId,
                'branch_id' => $user->branch_id
            ])
            ->one();

        if (!$product) {
            Yii::$app->session->setFlash('error', 'Product not found.');
            return $this->refresh();
        }

        if ($product->stock_quantity < $quantity) {
            Yii::$app->session->setFlash('error', 'Insufficient stock.');
            return $this->refresh();
        }

        // =========================
        // CALC
        // =========================
        $subtotal = $product->selling_price * $quantity;
        $profit   = ($product->selling_price - $product->buying_price) * $quantity;

        $transaction = Yii::$app->db->beginTransaction();

        try {

            // =========================
            // SALE
            // =========================
            $sale = new Sale();
            $sale->business_id  = $user->branch->business_id;
            $sale->branch_id    = $user->branch_id;
            $sale->user_id      = $user->id;
            $sale->total_amount = $subtotal;
            $sale->total_profit = $profit;
            $sale->status       = 'completed';

            if (!$sale->save()) {
                throw new \Exception(json_encode($sale->errors));
            }

            // =========================
            // SALE ITEM (FIXED FK)
            // =========================
            $item = new SaleItem();
            $item->sale_id   = $sale->id;
            $item->product_id = $product->id;

            $item->branch_id   = $user->branch_id;
            $item->business_id = $user->branch->business_id;

            $item->quantity      = $quantity;
            $item->selling_price = $product->selling_price;
            $item->buying_price  = $product->buying_price;

            $item->subtotal = $subtotal;
            $item->profit   = $profit;

            if (!$item->save()) {
                throw new \Exception(json_encode($item->errors));
            }

            // =========================
            // STOCK UPDATE
            // =========================
            StockService::decreaseStock(
                $product->id,
                $user->branch_id,
                $user->id,
                $quantity,
                "Sale #{$sale->id}"
            );

            $transaction->commit();

            Yii::$app->session->setFlash('success', 'Sale completed successfully.');

            return $this->redirect(['index']);

        } catch (\Exception $e) {

            $transaction->rollBack();

            Yii::$app->session->setFlash('error', $e->getMessage());

            return $this->refresh();
        }
    }
}
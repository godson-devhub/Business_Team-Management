<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;

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

                            return Yii::$app
                                ->user
                                ->identity
                                ->role === 'seller';
                        }
                    ],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $sales = Sale::find()
            ->orderBy(['id' => SORT_DESC])
            ->all();

        return $this->render('index', [
            'sales' => $sales
        ]);
    }

    public function actionCreate()
    {
        $user = Yii::$app->user->identity;

        $products = Product::find()
            ->where([
                'branch_id' => $user->branch_id
            ])
            ->all();

        if (Yii::$app->request->isPost) {

            $productId = Yii::$app->request
                ->post('product_id');

            $quantity = Yii::$app->request
                ->post('quantity');

            $product = Product::findOne($productId);

            if ($product && $quantity > 0) {

                $subtotal =
                    $product->selling_price * $quantity;

                $profit =
                    ($product->selling_price
                    - $product->buying_price)
                    * $quantity;

                // CREATE SALE
                $sale = new Sale();

                $sale->branch_id =
                    $user->branch_id;

                $sale->seller_id =
                    $user->id;

                $sale->total_amount =
                    $subtotal;

                $sale->total_profit =
                    $profit;

                $sale->save();

                // SALE ITEM
                $item = new SaleItem();

                $item->sale_id = $sale->id;

                $item->product_id = $product->id;

                $item->quantity = $quantity;

                $item->buying_price =
                    $product->buying_price;

                $item->selling_price =
                    $product->selling_price;

                $item->subtotal = $subtotal;

                $item->profit = $profit;

                $item->save();

                // DECREASE STOCK
                StockService::decreaseStock(
                    $product->id,
                    $quantity,
                    'Product sold'
                );

                Yii::$app->session
                    ->setFlash(
                        'success',
                        'Sale completed successfully'
                    );

                return $this->redirect(['index']);
            }
        }

        return $this->render('create', [
            'products' => $products
        ]);
    }
}
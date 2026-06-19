<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;

use common\models\Product;
use common\models\Purchase;
use common\models\PurchaseItem;

use common\services\StockService;

class PurchaseController extends Controller
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
        $purchases = Purchase::find()
            ->orderBy(['id' => SORT_DESC])
            ->all();

        return $this->render('index', [
            'purchases' => $purchases
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

            $productId = Yii::$app
                ->request
                ->post('product_id');

            $quantity = (int) Yii::$app
                ->request
                ->post('quantity');

            $supplier = Yii::$app
                ->request
                ->post('supplier_name');

            $product = Product::findOne($productId);

            if ($product && $quantity > 0) {

                $subtotal =
                    $product->buying_price * $quantity;

                // CREATE PURCHASE
                $purchase = new Purchase();

                $purchase->business_id =
                    $user->branch->business_id;

                $purchase->branch_id =
                    $user->branch_id;

                $purchase->user_id =
                    $user->id;

                $purchase->supplier_name =
                    $supplier;

                $purchase->total_amount =
                    $subtotal;

                $purchase->status ='completed';
                
                $purchase->created_at =
                    time();

                $purchase->save(false);

                // PURCHASE ITEM
                $item = new PurchaseItem();

                $item->purchase_id =
                    $purchase->id;

                $item->product_id =
                    $product->id;

                $item->business_id =
                    $user->branch->business_id; 
                    
                $item->branch_id =
                    $user->branch_id;    
                

                $item->quantity =
                    $quantity;

                $item->buying_price =
                    $product->buying_price;

                $item->subtotal =
                    $subtotal;
                
                $item->created_at = time();
                
                
                $item->save(false);

                // INCREASE STOCK
                StockService::increaseStock(
                    $product->id,
                    $user->branch_id,
                    $user->id,
                    (int)$quantity,
                    'Stock purchased'
                );

                Yii::$app->session
                    ->setFlash(
                        'success',
                        'Purchase completed'
                    );

                return $this->redirect(['index']);
            }
        }

        return $this->render('create', [
            'products' => $products
        ]);
    }
}
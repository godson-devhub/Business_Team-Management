<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;
use yii\web\ForbiddenHttpException;
use yii\filters\AccessControl;

use common\models\Branch;
use common\models\Business;
use common\models\Analytics;

class AnalyticsController extends Controller
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
                                && Yii::$app->user->identity->role === 'owner';
                        }
                    ],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $user = Yii::$app->user->identity;

        if (!$user) {
            throw new ForbiddenHttpException("Unauthorized");
        }

        // =========================================
        // 🔥 FIX 1: GET ALL BUSINESSES (NOT ONE)
        // =========================================
        $businesses = Business::find()
            ->where(['owner_id' => $user->id])
            ->all();

        if (empty($businesses)) {
            throw new ForbiddenHttpException("No business found");
        }

        // extract business IDs
        $businessIds = array_map(fn($b) => $b->id, $businesses);

        // =========================================
        // 🔥 FIX 2: GET ALL BRANCHES (MULTI BUSINESS)
        // =========================================
        $branches = Branch::find()
            ->where(['business_id' => $businessIds])
            ->orderBy(['name' => SORT_ASC])
            ->all();

        if (empty($branches)) {
            throw new ForbiddenHttpException("No branches found for your business");
        }

        // =========================================
        // BRANCH SELECTION SAFE
        // =========================================
        $branchId = Yii::$app->request->get('branch_id');

        if (!$branchId && isset($branches[0])) {
            $branchId = $branches[0]->id;
        }

        $date  = Yii::$app->request->get('date', date('Y-m-d'));
        $month = Yii::$app->request->get('month', date('Y-m'));

        // =========================================
        // AJAX RESPONSE
        // =========================================
        if (Yii::$app->request->get('ajax') == 1) {

            Yii::$app->response->format = Response::FORMAT_JSON;

            if (!$branchId) {
                return ['error' => 'Branch not selected'];
            }

            return [
                'dailySales' => Analytics::getDailySales($branchId, $date),
                'dailyProfit' => Analytics::getDailyProfit($branchId, $date),

                'monthlySales' => Analytics::getMonthlySales($branchId, $month),
                'monthlyProfit' => Analytics::getMonthlyProfit($branchId, $month),

                'totalProducts' => Analytics::getTotalProducts($branchId),
                'stockValue' => Analytics::getStockValue($branchId),

                'labels' => array_column(
                    Analytics::getWeeklySalesChart($branchId),
                    'label'
                ),
                'values' => array_column(
                    Analytics::getWeeklySalesChart($branchId),
                    'value'
                ),
            ];
        }

        // =========================================
        // VIEW
        // =========================================
        return $this->render('index', [
            'branches' => $branches,
            'branchId' => $branchId,
            'selectedDate' => $date,
            'selectedMonth' => $month,
        ]);
    }
}
<?php

declare(strict_types=1);

namespace backend\controllers;

use common\models\LoginForm;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\ErrorAction;
use yii\web\Response;

/**
 * Site Controller
 */

class SiteController extends Controller
{
    /**
     * Behaviors
     */
    public function behaviors(): array
    {
        return [

            'access' => [

                'class' => AccessControl::class,

                'rules' => [

                    // PUBLIC PAGES
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],

                    // AUTHENTICATED USERS
                    [
                        'actions' => ['logout', 'index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],

            'verbs' => [

                'class' => VerbFilter::class,

                'actions' => [

                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Error actions
     */
    public function actions(): array
    {
        return [

            'error' => [
                'class' => ErrorAction::class,
            ],
        ];
    }

    /**
     * Homepage
     */
    public function actionIndex(): string|Response
    {
        // USER MUST LOGIN
        if (Yii::$app->user->isGuest) {

            return $this->redirect(['site/login']);
        }

        $user = Yii::$app->user->identity;

        // OWNER DASHBOARD
        if ($user->role === 'owner') {

            return $this->redirect(['/owner-dashboard/index']);
        }

        // SELLER DASHBOARD
        if ($user->role === 'seller') {

            return $this->redirect(['/seller/dashboard']);
        }

        return $this->render('index');
    }

    /**
     * Login action
     */
    public function actionLogin(): string|Response
    {
        // ALREADY LOGGED IN
        if (!Yii::$app->user->isGuest) {

            return $this->goHome();
        }

        // LOGIN LAYOUT
        $this->layout = 'blank';

        $model = new LoginForm();

        // LOGIN PROCESS
        if (
            $model->load(Yii::$app->request->post())
            && $model->login()
        ) {

            $user = Yii::$app->user->identity;

            // OWNER LOGIN
            if ($user->role === 'owner') {

                return $this->redirect([
                    '/owner-dashboard/index',
                ]);
            }

            // SELLER LOGIN
            if ($user->role === 'seller') {

                return $this->redirect([
                    '/seller/dashboard',
                ]);
            }

            return $this->goHome();
        }

        $model->password = '';

        return $this->render('login', [

            'model' => $model,
        ]);
    }

    /**
     * Logout action
     */
    public function actionLogout(): Response
    {
        Yii::$app->user->logout();

        return $this->redirect(['site/login']);
    }
}
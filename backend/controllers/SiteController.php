<?php

declare(strict_types=1);

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\ErrorAction;

use common\models\LoginForm;
use common\models\SignupForm;

class SiteController extends Controller
{
    public function behaviors(): array
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [

                    // PUBLIC ROUTES (LOGIN + SIGNUP + ERROR)
                    [
                        'actions' => ['login', 'signup', 'error'],
                        'allow' => true,
                    ],

                    // AUTH USERS ONLY
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
                    'logout' => ['POST'],
                ],
            ],
        ];
    }

    public function actions(): array
    {
        return [
            'error' => [
                'class' => ErrorAction::class,
            ],
        ];
    }

    public function actionIndex(): Response|string
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['site/login']);
        }

        $user = Yii::$app->user->identity;

        return match ($user->role) {
            'owner'  => $this->redirect(['/owner-dashboard/index']),
            'seller' => $this->redirect(['/seller/index']),
            default  => $this->goHome(),
        };
    }

    public function actionLogin(): Response|string
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $this->layout = 'auth';

        $model = new LoginForm();

        if ($model->load(Yii::$app->request->post()) && $model->login()) {

            $user = Yii::$app->user->identity;

            Yii::$app->session->setFlash('success', 'Login successful');

            return match ($user->role) {
                'owner'  => $this->redirect(['/owner-dashboard/index']),
                'seller' => $this->redirect(['/seller/index']),
                default  => $this->goHome(),
            };
        }

        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * =========================
     * PUBLIC SIGNUP (FIXED)
     * =========================
     */
    public function actionSignup(): Response|string
    {
        $this->layout = 'auth';

        $model = new SignupForm();

        if ($model->load(Yii::$app->request->post())) {

            $user = $model->signup();

            if ($user) {



                Yii::$app->user->login($user);

                Yii::$app->session->setFlash(
                    'success',
                    'Account created successfully  - welcome aboard!'
                );



                return match ($user->role) {
                    'owner' => $this->redirect(['/owner-dashboard/index']),
                    'seller' => $this->redirect(['/seller/index']),
                    default => $this->goHome(),
                };
            }

            Yii::$app->session->setFlash(
                'error',
                'Signup failed. Please try again.'
            );
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    public function actionLogout(): Response
    {
        Yii::$app->user->logout();

        return $this->redirect(['site/login']);
    }
}
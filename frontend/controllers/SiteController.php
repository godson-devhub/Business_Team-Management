<?php

declare(strict_types=1);

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;
use yii\web\BadRequestHttpException;
use yii\web\ErrorAction;

use yii\filters\AccessControl;
use yii\filters\VerbFilter;

use yii\captcha\CaptchaAction;

use yii\base\InvalidArgumentException;

use yii\mail\MailerInterface;

use common\models\LoginForm;

use frontend\models\ContactForm;
use frontend\models\SignupForm;
use frontend\models\VerifyEmailForm;
use frontend\models\ResetPasswordForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResendVerificationEmailForm;

class SiteController extends Controller
{
    public function __construct(
        $id,
        $module,
        private readonly MailerInterface $mailer,
        $config = []
    ) {
        parent::__construct($id, $module, $config);
    }

    public function behaviors(): array
    {
        return [

            'access' => [

                'class' => AccessControl::class,

                'only' => [
                    'logout',
                    'signup'
                ],

                'rules' => [

                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],

                    [
                        'actions' => ['logout'],
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

    public function actions(): array
    {
        return [

            'error' => [
                'class' => ErrorAction::class,
            ],

            'captcha' => [
                'class' => CaptchaAction::class,
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],

        ];
    }

    /*
    |--------------------------------------------------------------------------
    | LANDING PAGE
    |--------------------------------------------------------------------------
    */

    public function actionIndex(): string
    {
        return $this->render('index');
    }

    /*
    |--------------------------------------------------------------------------
    | FEATURES PAGE
    |--------------------------------------------------------------------------
    */

    public function actionFeatures(): string
    {
        return $this->render('features');
    }

    /*
    |--------------------------------------------------------------------------
    | PRICING PAGE
    |--------------------------------------------------------------------------
    */

    public function actionPricing(): string
    {
        return $this->render('pricing');
    }

    /*
    |--------------------------------------------------------------------------
    | ABOUT PAGE
    |--------------------------------------------------------------------------
    */

    public function actionAbout(): string
    {
        return $this->render('about');
    }

    /*
    |--------------------------------------------------------------------------
    | CONTACT PAGE
    |--------------------------------------------------------------------------
    */

    public function actionContact(): string|Response
    {
        $model = new ContactForm();

        if (
            $model->load(Yii::$app->request->post())
            && $model->validate()
        ) {

            $sent = $model->sendEmail(
                $this->mailer,
                Yii::$app->params['adminEmail'],
                Yii::$app->params['senderEmail'],
                Yii::$app->params['senderName']
            );

            if ($sent) {

                Yii::$app->session->setFlash(
                    'success',
                    'Thank you for contacting us.'
                );

            } else {

                Yii::$app->session->setFlash(
                    'error',
                    'Unable to send your message.'
                );
            }

            return $this->refresh();
        }

        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | LOGIN
    |--------------------------------------------------------------------------
    */

    public function actionLogin(): string|Response
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();

        if (
            $model->load(Yii::$app->request->post())
            && $model->login()
        ) {
            return $this->goBack();
        }

        $model->password = '';

        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | LOGOUT
    |--------------------------------------------------------------------------
    */

    public function actionLogout(): Response
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /*
    |--------------------------------------------------------------------------
    | SIGNUP
    |--------------------------------------------------------------------------
    */

    public function actionSignup(): string|Response
    {
        $model = new SignupForm();

        if (
            $model->load(Yii::$app->request->post())
            && $model->signup(
                $this->mailer,
                Yii::$app->params['supportEmail'],
                Yii::$app->name
            )
        ) {

            Yii::$app->session->setFlash(
                'success',
                'Registration successful. Check your email.'
            );

            return $this->goHome();
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | VERIFY EMAIL
    |--------------------------------------------------------------------------
    */

    public function actionVerifyEmail(string $token): Response
    {
        try {

            $model = new VerifyEmailForm($token);

        } catch (InvalidArgumentException $e) {

            throw new BadRequestHttpException(
                $e->getMessage()
            );
        }

        if ($model->verifyEmail()) {

            Yii::$app->session->setFlash(
                'success',
                'Email verified successfully.'
            );

            return $this->goHome();
        }

        Yii::$app->session->setFlash(
            'error',
            'Invalid verification link.'
        );

        return $this->goHome();
    }

    /*
    |--------------------------------------------------------------------------
    | PASSWORD RESET REQUEST
    |--------------------------------------------------------------------------
    */

    public function actionRequestPasswordReset(): string|Response
    {
        $model = new PasswordResetRequestForm();

        if (
            $model->load(Yii::$app->request->post())
            && $model->validate()
        ) {

            if (
                $model->sendEmail(
                    $this->mailer,
                    Yii::$app->params['supportEmail'],
                    Yii::$app->name
                )
            ) {

                Yii::$app->session->setFlash(
                    'success',
                    'Check your email.'
                );

                return $this->goHome();
            }

            Yii::$app->session->setFlash(
                'error',
                'Unable to process request.'
            );
        }

        return $this->render(
            'requestPasswordResetToken',
            [
                'model' => $model,
            ]
        );
    }

    /*
    |--------------------------------------------------------------------------
    | RESET PASSWORD
    |--------------------------------------------------------------------------
    */

    public function actionResetPassword(
        string $token
    ): string|Response {

        try {

            $model = new ResetPasswordForm(
                $token
            );

        } catch (InvalidArgumentException $e) {

            throw new BadRequestHttpException(
                $e->getMessage()
            );
        }

        if (
            $model->load(Yii::$app->request->post())
            && $model->validate()
            && $model->resetPassword()
        ) {

            Yii::$app->session->setFlash(
                'success',
                'Password updated successfully.'
            );

            return $this->goHome();
        }

        return $this->render(
            'resetPassword',
            [
                'model' => $model,
            ]
        );
    }

    /*
    |--------------------------------------------------------------------------
    | RESEND VERIFICATION EMAIL
    |--------------------------------------------------------------------------
    */

    public function actionResendVerificationEmail(): string|Response
    {
        $model = new ResendVerificationEmailForm();

        if (
            $model->load(Yii::$app->request->post())
            && $model->validate()
        ) {

            if (
                $model->sendEmail(
                    $this->mailer,
                    Yii::$app->params['supportEmail'],
                    Yii::$app->name
                )
            ) {

                Yii::$app->session->setFlash(
                    'success',
                    'Verification email sent.'
                );

                return $this->goHome();
            }

            Yii::$app->session->setFlash(
                'error',
                'Unable to resend verification email.'
            );
        }

        return $this->render(
            'resendVerificationEmail',
            [
                'model' => $model,
            ]
        );
    }
}

<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use common\models\User;

class UserController extends Controller
{
    public function actionCreateSeller()
    {
        $user = new User();

        $user->username = "Niko";
        $user->email = "mulax01@gmail.com";
        $user->setPassword("123456");
        $user->generateAuthKey();
        $user->role = "seller";
        $user->branch_id = 1;

        if ($user->save()) {
            return "Seller created successfully";
        }

        return $user->errors;
    }
}
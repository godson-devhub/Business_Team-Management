<?php

namespace console\controllers;

use yii\console\Controller;
use common\models\User;

class UserController extends Controller
{
    public function actionCreateOwner()
    {
        $user = new User();

        $user->username = 'Godson Mshiu';

        $user->email = 'mshiugodson80@gmail.com';

        $user->role = 'owner';

        $user->status = 10;

        $user->created_at = time();
        $user->updated_at = time();

        $user->generateAuthKey();

        $user->setPassword('075458');

        if ($user->save()) {

            echo "OWNER CREATED SUCCESSFULLY\n";

        } else {

            print_r($user->errors);
        }
    }


    public function actionCreateSeller()
    {
        $user = new User();

        $user->username = "mulax";
        $user->email = "mulax01@gmail.com";
        $user->setPassword("123456");
        $user->generateAuthKey();
        $user->role = "seller";
        $user->branch_id = 1;

        $user->save();

        echo "Seller created\n";
    }
}
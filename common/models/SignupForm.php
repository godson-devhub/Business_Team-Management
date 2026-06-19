<?php

namespace common\models;

use Yii;
use yii\base\Model;
use common\models\User;

class SignupForm extends Model
{
    public $username;
    public $email;
    public $password;

    public function rules(): array
    {
        return [
            [['username', 'email', 'password'], 'required'],
            ['username', 'trim'],
            ['email', 'trim'],
            ['email', 'email'],
            ['username', 'string', 'min' => 3, 'max' => 50],
            ['password', 'string', 'min' => 6],
            ['username', 'unique', 'targetClass' => User::class],
            ['email', 'unique', 'targetClass' => User::class],
        ];
    }

    public function signup(): ?User
    {
        if (!$this->validate()) {
            return null;
        }

        $transaction = Yii::$app->db->beginTransaction();

        try {

            /**
             * 🔥 SYSTEM RULE:
             * SIGNUP ALWAYS CREATES OWNER ONLY
             */
            $user = new User();

            $user->username = $this->username;
            $user->email = $this->email;
            $user->setPassword($this->password);
            $user->generateAuthKey();

            $user->role = User::ROLE_OWNER;
            $user->status = User::STATUS_ACTIVE;

            if (!$user->save()) {
                $this->addErrors($user->getErrors());
                $transaction->rollBack();
                return null;
            }

            $transaction->commit();
            return $user;

        } catch (\Throwable $e) {

            $transaction->rollBack();

            Yii::error("Signup Error: " . $e->getMessage(), __METHOD__);

            $this->addError('username', 'System error occurred');

            return null;
        }
    }
}
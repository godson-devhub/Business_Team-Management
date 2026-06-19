<?php

declare(strict_types=1);

namespace common\models;

use Yii;
use yii\base\Model;

/**
 * LoginForm (ROLE BASED READY)
 */
class LoginForm extends Model
{
    public string $username = '';
    public string $password = '';
    public bool $rememberMe = true;

    private ?User $_user = null;

    /**
     * RULES
     */
    public function rules(): array
    {
        return [
            [['username', 'password'], 'required'],
            ['rememberMe', 'boolean'],
            ['password', 'validatePassword'],
        ];
    }

    /**
     * PASSWORD VALIDATION
     */
    public function validatePassword(string $attribute, $params): void
    {
        if ($this->hasErrors()) {
            return;
        }

        $user = $this->getUser();

        if (!$user || !$user->validatePassword($this->password)) {
            $this->addError($attribute, 'Incorrect username or password.');
        }

        // OPTIONAL SECURITY CHECKS
        if ($user && (int)$user->status !== User::STATUS_ACTIVE) {
            $this->addError($attribute, 'Account is inactive.');
        }
    }

    /**
     * LOGIN USER
     */
    public function login(): bool
    {
        if (!$this->validate()) {
            return false;
        }

        $duration = $this->rememberMe
            ? 3600 * 24 * 30
            : 0;

        return Yii::$app->user->login($this->getUser(), $duration);
    }

    /**
     * GET USER BY USERNAME
     */
    protected function getUser(): ?User
    {
        if ($this->_user === null) {
            $this->_user = User::findByUsername($this->username);
        }

        return $this->_user;
    }

    /**
     * OPTIONAL: RETURN USER ROLE (helpful for debugging / extensions)
     */
    public function getUserRole(): ?string
    {
        return $this->getUser()?->role;
    }
}
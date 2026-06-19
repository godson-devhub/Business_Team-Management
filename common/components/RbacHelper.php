<?php

namespace common\components;

use Yii;

class RbacHelper
{
    /**
     * =========================
     * ROLE CHECKS
     * =========================
     */

    public static function isOwner($user): bool
    {
        return $user && $user->role === 'owner';
    }

    public static function isSeller($user): bool
    {
        return $user && $user->role === 'seller';
    }

    public static function isAdmin($user): bool
    {
        return $user && $user->role === 'admin';
    }

    /**
     * =========================
     * RBAC PERMISSION CHECK
     * (Yii RBAC READY)
     * =========================
     */
    public static function can(string $permission): bool
    {
        return Yii::$app->authManager->checkAccess(
            Yii::$app->user->id,
            $permission
        );
    }

    /**
     * =========================
     * ROLE BASED REDIRECT
     * =========================
     */
    public static function redirectByRole($user)
    {
        if (!$user) {
            return Yii::$app->controller->redirect(['/site/login']);
        }

        return match ($user->role) {

            'owner' => Yii::$app->controller->redirect(['/owner-dashboard/index']),

            'seller' => Yii::$app->controller->redirect(['/seller/index']),

            default => Yii::$app->controller->goHome(),
        };
    }

    /**
     * =========================
     * FORCE ACCESS DENIED
     * =========================
     */
    public static function deny()
    {
        throw new \yii\web\ForbiddenHttpException("You are not allowed to access this page.");
    }
}
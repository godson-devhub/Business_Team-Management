<?php

declare(strict_types=1);

namespace common\bootstrap;

use Yii;
use yii\base\Application;
use yii\base\BootstrapInterface;
use yii\mail\MailerInterface;

/**
 * Safe Mailer Bootstrap
 * ONLY binds mailer after application components are ready
 */
final class MailerBootstrap implements BootstrapInterface
{
    public function bootstrap($app): void
    {
        // 🚨 SAFETY CHECK (IMPORTANT)
        if (!$app->has('mailer')) {
            return;
        }

        $mailer = $app->mailer;

        // ensure mailer is valid before binding
        if ($mailer instanceof MailerInterface) {
            Yii::$container->setSingleton(MailerInterface::class, $mailer);
        }
    }
}
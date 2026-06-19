<?php

use yii\helpers\Html;
use yii\helpers\Url;

$user = Yii::$app->user->identity;
$isGuest = Yii::$app->user->isGuest;
$role = $user->role ?? null;

$currentRoute = Yii::$app->controller->route;

function isActive($route, $currentRoute)
{
    return strpos($currentRoute, $route) === 0 ? 'active' : '';
}

?>

<aside class="app-sidebar">

    <!-- LOGO -->
    <div class="sidebar-logo">

        <div class="logo-icon">
            <img src="<?= Yii::getAlias('@web') ?>/uploads/icon2.png"
                 style="width:100%;height:100%;object-fit:contain;">
        </div>

        <div>
            <div class="logo-title">Business Team</div>
            <div class="logo-subtitle">Management System</div>
        </div>

    </div>

    <!-- USER INFO -->
    <?php if (!$isGuest): ?>
        <div class="sidebar-user">

            <div class="avatar">
                <?= strtoupper(substr($user->username, 0, 1)) ?>
            </div>

            <div>
                <div class="username">
                    <?= Html::encode($user->username) ?>
                </div>

                <div class="role">
                    <?= strtoupper($role) ?>
                </div>
            </div>

        </div>
    <?php endif; ?>

    <!-- MENU -->
    <div class="sidebar-menu">

        <?php if ($role === 'owner'): ?>

            <div class="menu-title">MAIN</div>

            <?= Html::a('🏠 Dashboard', ['/owner-dashboard/index'], [
                'class' => 'menu-link ' . isActive('owner-dashboard', $currentRoute)
            ]) ?>

            <div class="menu-title">BUSINESS</div>

            <?= Html::a('🏢 Businesses', ['/business/index'], [
                'class' => 'menu-link ' . isActive('business', $currentRoute)
            ]) ?>

            <?= Html::a('🏬 Branches', ['/branch/index'], [
                'class' => 'menu-link ' . isActive('branch', $currentRoute)
            ]) ?>

            <div class="menu-title">USERS</div>

            <?= Html::a('👤 Sellers', ['/owner-seller/index'], [
                'class' => 'menu-link ' . isActive('seller', $currentRoute)
            ]) ?>

            <div class="menu-title">INVENTORY</div>

            <?= Html::a('📦 Products', ['/owner-product/index'], [
                'class' => 'menu-link ' . isActive('product', $currentRoute)
            ]) ?>


            <div class="menu-title">REPORTS</div>

            <?= Html::a('📊 Analytics', ['/analytics/index'], [
                'class' => 'menu-link ' . isActive('analytics', $currentRoute)
            ]) ?>

        <?php endif; ?>

        <?php if ($role === 'seller'): ?>

            <div class="menu-title">SELLER PANEL</div>

            <?= Html::a('🏠 Dashboard', ['/seller/index'], [
                'class' => 'menu-link ' . isActive('seller/index', $currentRoute)
            ]) ?>

            <?= Html::a('📦 Products', ['/products'], [
                'class' => 'menu-link'
            ]) ?>

            <?= Html::a('💰 Sales', ['/sale/index'], [
                'class' => 'menu-link'
            ]) ?>

            <?= Html::a('🛒 Purchases', ['/purchase/index'], [
                'class' => 'menu-link'
            ]) ?>

        <?php endif; ?>

    </div>

    <!-- FOOTER -->
    <?php if (!$isGuest): ?>
        <div class="sidebar-footer">

            <form action="<?= Url::to(['/site/logout']) ?>" method="post">
                <input type="hidden"
                       name="<?= Yii::$app->request->csrfParam ?>"
                       value="<?= Yii::$app->request->csrfToken ?>">

                <button type="submit" class="logout-link">
                    🚪 Logout
                </button>
            </form>

        </div>
    <?php endif; ?>

</aside>

<style>

/* ================= SIDEBAR BASE ================= */

.app-sidebar {

    width: 240px;
    height: 100vh;
    position: fixed;
    top: 0;
    left: 0;

    background: rgba(15, 23, 42, 0.95);
    backdrop-filter: blur(20px);

    border-right: 1px solid rgba(255,255,255,0.08);

    color: #fff;

    padding: 20px 16px;

    overflow-y: auto;

    transition: 0.3s ease;
}

/* ================= LOGO ================= */

.sidebar-logo {

    display: flex;
    align-items: center;
    gap: 12px;

    padding: 10px;

    border-radius: 14px;

    background: rgba(255,255,255,0.04);

    margin-bottom: 20px;
}

.logo-icon {

    width: 48px;
    height: 48px;

    border-radius: 12px;

    overflow: hidden;
}

/* ================= USER ================= */

.sidebar-user {

    display: flex;
    align-items: center;
    gap: 12px;

    padding: 12px;

    border-radius: 14px;

    background: rgba(255,255,255,0.05);

    margin-bottom: 20px;
}

.avatar {

    width: 42px;
    height: 42px;

    border-radius: 12px;

    display: flex;
    align-items: center;
    justify-content: center;

    font-weight: bold;

    background: linear-gradient(135deg,#3b82f6,#8b5cf6);
}

/* ================= MENU ================= */

.menu-title {

    margin: 18px 0 8px;

    font-size: 11px;

    color: #94a3b8;

    letter-spacing: 1px;

    font-weight: 700;
}

.menu-link {

    display: block;

    padding: 10px 12px;

    margin-bottom: 6px;

    border-radius: 10px;

    text-decoration: none;

    color: #e2e8f0;

    transition: 0.2s ease;
}

.menu-link:hover {

    background: rgba(59,130,246,0.15);

    transform: translateX(4px);

    color: #fff;
}

/* ACTIVE LINK */
.menu-link.active {

    background: rgba(59,130,246,0.25);

    border-left: 3px solid #3b82f6;
}

/* ================= FOOTER ================= */

.sidebar-footer {

    margin-top: 20px;

    padding-top: 15px;

    border-top: 1px solid rgba(255,255,255,0.08);
}

.logout-link {

    width: 100%;

    padding: 10px;

    border: none;

    border-radius: 10px;

    background: #dc2626;

    color: white;

    font-weight: 600;

    cursor: pointer;

    transition: 0.2s ease;
}

.logout-link:hover {

    background: #b91c1c;

    transform: translateY(-2px);
}

/* ================= MOBILE ================= */

@media(max-width: 992px){

    .app-sidebar{

        width: 80px;
    }

    .menu-title,
    .logo-title,
    .logo-subtitle,
    .username,
    .role {

        display: none;
    }

    .menu-link {

        text-align: center;
    }
}

</style>
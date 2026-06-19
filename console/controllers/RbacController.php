<?php

namespace console\controllers;

use Yii;
use yii\console\Controller;
use yii\rbac\DbManager;

class RbacController extends Controller
{
    /**
     * STEP B: INIT ROLES & PERMISSIONS
     */
    public function actionInit()
    {
        $auth = Yii::$app->authManager;

        // =========================
        // CLEAR OLD DATA (optional)
        // =========================
        $auth->removeAll();

        echo "🔄 RBAC cleared...\n";

        // =========================
        // PERMISSIONS
        // =========================

        $dashboardOwner = $auth->createPermission('dashboardOwner');
        $dashboardOwner->description = 'Access owner dashboard';
        $auth->add($dashboardOwner);

        $dashboardSeller = $auth->createPermission('dashboardSeller');
        $dashboardSeller->description = 'Access seller dashboard';
        $auth->add($dashboardSeller);

        $manageProducts = $auth->createPermission('manageProducts');
        $manageProducts->description = 'Manage products';
        $auth->add($manageProducts);

        $manageSales = $auth->createPermission('manageSales');
        $manageSales->description = 'Manage sales';
        $auth->add($manageSales);

        $managePurchases = $auth->createPermission('managePurchases');
        $managePurchases->description = 'Manage purchases';
        $auth->add($managePurchases);

        $manageBranches = $auth->createPermission('manageBranches');
        $manageBranches->description = 'Manage branches';
        $auth->add($manageBranches);

        $manageBusinesses = $auth->createPermission('manageBusinesses');
        $manageBusinesses->description = 'Manage businesses';
        $auth->add($manageBusinesses);

        $manageSellers = $auth->createPermission('manageSellers');
        $manageSellers->description = 'Manage sellers (owner only)';
        $auth->add($manageSellers);

        // =========================
        // ROLES
        // =========================

        $owner = $auth->createRole('owner');
        $auth->add($owner);

        $seller = $auth->createRole('seller');
        $auth->add($seller);

        // =========================
        // ASSIGN PERMISSIONS TO ROLES
        // =========================

        // OWNER (full access)
        $auth->addChild($owner, $dashboardOwner);
        $auth->addChild($owner, $manageProducts);
        $auth->addChild($owner, $manageSales);
        $auth->addChild($owner, $managePurchases);
        $auth->addChild($owner, $manageBranches);
        $auth->addChild($owner, $manageBusinesses);
        $auth->addChild($owner, $manageSellers);

        // SELLER (limited access)
        $auth->addChild($seller, $dashboardSeller);
        $auth->addChild($seller, $manageProducts);
        $auth->addChild($seller, $manageSales);
        $auth->addChild($seller, $managePurchases);

        echo "✅ RBAC roles & permissions created successfully!\n";
    }
}
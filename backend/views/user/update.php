<?php

use yii\helpers\Html;

/** @var $model common\models\User */

$this->title = 'Update Seller: ' . $model->username;

?>

<div class="user-update">

    <h2>✏️ Update Seller</h2>

    <?= $this->render('_form', [
        'model' => $model,
        'branches' => \common\models\Branch::find()->all()
    ]) ?>

</div>
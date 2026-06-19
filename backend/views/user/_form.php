<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var $model common\models\User */
/** @var $branches common\models\Branch[] */

?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'username')->textInput() ?>

    <?= $form->field($model, 'email')->textInput() ?>

    <?= $form->field($model, 'password')->passwordInput([
        'placeholder' => 'Enter password (for create or reset)'
    ]) ?>

    <?= $form->field($model, 'branch_id')->dropDownList(
        \yii\helpers\ArrayHelper::map($branches, 'id', 'name'),
        ['prompt' => 'Select Branch']
    ) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
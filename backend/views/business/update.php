<?php

/**
 * @var \common\models\Business $model
 */

use yii\widgets\ActiveForm;
use yii\helpers\Html;

$this->title = 'Update Business';
?>

<div style="padding:40px; color:white;">

<h1>✏ Update Business</h1>

<?php $form = ActiveForm::begin(); ?>

<?= $form->field($model, 'name') ?>
<?= $form->field($model, 'description')->textarea(['rows'=>4]) ?>
<?= $form->field($model, 'email') ?>
<?= $form->field($model, 'phone') ?>
<?= $form->field($model, 'address') ?>

<div>
    <?= Html::submitButton('Update', [
        'class'=>'btn btn-primary'
    ]) ?>
</div>

<?php ActiveForm::end(); ?>

</div>
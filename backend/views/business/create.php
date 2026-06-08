<?php
/**
 * @var \common\models\Business $model
 */
use yii\widgets\ActiveForm;
use yii\helpers\Html;

$this->title = 'Create Business';
?>

<div style="padding:40px; color:white;">

<h1>➕ Create Business</h1>

<?php $form = ActiveForm::begin(); ?>

<?= $form->field($model, 'name')->textInput(['placeholder'=>'Business name']) ?>

<?= $form->field($model, 'description')->textarea(['rows'=>4]) ?>

<?= $form->field($model, 'email') ?>

<?= $form->field($model, 'phone') ?>

<?= $form->field($model, 'address') ?>

<div>
    <?= Html::submitButton('Save Business', [
        'class'=>'btn btn-success'
    ]) ?>
</div>

<?php ActiveForm::end(); ?>

</div>
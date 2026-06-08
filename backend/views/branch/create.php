<?php
/**
 * @var \common\models\Branch $model
 * @var \common\models\Business[] $businesses
 */


use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;

$this->title = 'Create Branch';
?>

<div style="padding:40px; color:white;">

<h1>➕ Create Branch</h1>

<?php $form = ActiveForm::begin(); ?>

<?= $form->field($model, 'business_id')
    ->dropDownList(
        ArrayHelper::map($businesses, 'id', 'name'),
        ['prompt' => 'Select Business']
    )
?>

<?= $form->field($model, 'name') ?>
<?= $form->field($model, 'location') ?>
<?= $form->field($model, 'address') ?>
<?= $form->field($model, 'phone') ?>
<?= $form->field($model, 'email') ?>

<?= Html::submitButton('Save Branch', [
    'class' => 'btn btn-success'
]) ?>

<?php ActiveForm::end(); ?>

</div>
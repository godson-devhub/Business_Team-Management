<?php
/**
 * @var \common\models\Branch $model
 * @var \common\models\Business[] $businesses
 */
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;

$this->title = 'Update Branch';
?>

<div style="padding:40px; color:white;">

<h1>✏ Update Branch</h1>

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

<?= Html::submitButton('Update', [
    'class' => 'btn btn-primary'
]) ?>

<?php ActiveForm::end(); ?>

</div>
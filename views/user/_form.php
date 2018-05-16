<?php
/**
 * Created by PhpStorm.
 * User: Arafeh
 * Date: 5/16/2018
 * Time: 3:38 PM
 */

/** @var $model User */

use app\models\User;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Alert;

if (!isset($model)) $model = new User();
?>

<?php if (isset($saved) && $saved): ?>
    <?= Alert::widget(['id' => 'form-state-alert', 'body' => 'saved', 'options' => ['class' => 'alert-info']]) ?>
    <script>if (window.gridControl) window.gridControl.shouldRefresh = true</script>
<?php endif; ?>

<?php $form = ActiveForm::begin([
    'id' => 'model-form',
    'action' => ['user/update'],
    'options' => ['data-pjax' => '']
]) ?>
<?= $form->field($model, 'UserId')->hiddenInput()->label(false) ?>
<?= $form->field($model, 'FirstName')->textInput() ?>
<?= $form->field($model, 'LastName')->textInput() ?>
<?= $form->field($model, 'Username')->textInput() ?>
<?= $form->field($model, 'Email')->textInput() ?>
<?= $form->field($model, 'Type')->dropDownList([1 => 'admin', 2 => 'user']) ?>
<?= \yii\bootstrap\Html::submitButton('submit', ['class' => 'btn btn-success']) ?>
<?= \yii\bootstrap\Html::button('close', ['data-dismiss' => "modal", 'class' => 'btn btn-danger']) ?>
<?php ActiveForm::end(); ?>

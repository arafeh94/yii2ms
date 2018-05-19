<?php
/**
 * Created by PhpStorm.
 * User: Arafeh
 * Date: 5/16/2018
 * Time: 3:38 PM
 */

/** @var $model Instructor */

use app\models\Department;
use app\models\Instructor;
use app\models\School;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Alert;
use yii\bootstrap\Html;
use yii\helpers\ArrayHelper;

if (!isset($model)) $model = new Instructor();
?>


<?php if (isset($saved) && $saved): ?>
    <?= Alert::widget(['id' => 'form-state-alert', 'body' => 'saved', 'options' => ['class' => 'alert-info']]) ?>
    <script>if (window.gridControl) window.gridControl.shouldRefresh = true</script>
<?php endif; ?>

<?php $form = ActiveForm::begin([
    'id' => 'model-form',
    'action' => ['instructor/update'],
    'options' => ['data-pjax' => '']
]) ?>
<?= $form->field($model, 'InstructorId')->hiddenInput()->label(false) ?>
<?= $form->field($model, 'UniversityId')->textInput() ?>
<?= $form->field($model, 'Title')->dropDownList(Yii::$app->params['titlesSelector']) ?>
<?= $form->field($model, 'FirstName')->textInput() ?>
<?= $form->field($model, 'LastName')->textInput() ?>
<?= $form->field($model, 'Email')->textInput() ?>
<?= $form->field($model, 'PhoneExtension')->textInput() ?>
<?= Html::submitButton(Html::tag('i', '', ['class' => 'glyphicon glyphicon-refresh spin hidden']) . ' submit', ['class' => 'btn btn-success', 'id' => 'modal-form-submit']) ?>
<?= Html::button('close', ['data-dismiss' => "modal", 'class' => 'btn btn-danger']) ?>
<?php ActiveForm::end(); ?>

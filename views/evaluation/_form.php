<?php
/**
 * Created by PhpStorm.
 * User: Arafeh
 * Date: 5/16/2018
 * Time: 3:38 PM
 */

/** @var $model EvaluationEmail */

/** @var $semester \app\models\Semester */

use app\models\EvaluationEmail;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Alert;
use yii\bootstrap\Html;

if (!isset($model)) $model = new EvaluationEmail();
?>


<?php if (isset($saved) && $saved): ?>
    <?= Alert::widget(['id' => 'form-state-alert', 'body' => 'saved', 'options' => ['class' => 'alert-info']]) ?>
    <script>if (window.gridControl) window.gridControl.shouldRefresh = true</script>
<?php endif; ?>

<?php $form = ActiveForm::begin([
    'id' => 'model-form',
    'action' => ['mailing/update'],
    'options' => ['data-pjax' => '']
]) ?>
<?= $form->field($model, 'EvaluationEmailId')->hiddenInput()->label(false) ?>
<?= $form->field($model, 'SemesterId')->dropDownList([$semester->SemesterId => $semester->Year . ' - ' . $semester->season->Name], ['data-add-value' => $semester->SemesterId, 'readonly' => 'readonly', 'disabled' => 'disabled']); ?>
<?= $form->field($model, 'Description')->textInput() ?>
<?= $form->field($model, 'Quarter')->dropDownList(Yii::$app->params['quarterSelector']) ?>
<?= $form->field($model, 'AvailableForInstructors')->dropDownList(Yii::$app->params['booleanSelector']) ?>
<?= Html::submitButton(Html::tag('i', '', ['class' => 'glyphicon glyphicon-refresh spin hidden']) . ' submit', ['class' => 'btn btn-success', 'id' => 'modal-form-submit']) ?>
<?= Html::button('close', ['data-dismiss' => "modal", 'class' => 'btn btn-danger']) ?>
<?php ActiveForm::end(); ?>

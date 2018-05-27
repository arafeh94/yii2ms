<?php
/**
 * Created by PhpStorm.
 * User: Arafeh
 * Date: 5/16/2018
 * Time: 3:38 PM
 */

/** @var $model StudyPlan */


use app\models\StudyPlan;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Alert;
use yii\bootstrap\Html;

?>


<?php if (isset($saved) && $saved): ?>
    <?= Alert::widget(['id' => 'form-state-alert', 'body' => 'saved', 'options' => ['class' => 'alert-info']]) ?>
    <script>if (window.gridControl) window.gridControl.shouldRefresh = true</script>
    <script>if (window.modalControl) window.modalControl.close()</script>
<?php endif; ?>

<?php $form = ActiveForm::begin([
    'id' => 'model-form',
    'action' => ["study-plan/update?major=$model->MajorId"],
    'options' => ['data-pjax' => '']
]) ?>
<?= $form->field($model, 'StudyPlanId')->hiddenInput()->label(false) ?>
<?= $form->field($model, 'Major')->hiddenInput(['value' => $model->MajorId])->label(false) ?>
<?= $form->field($model, 'CourseLetter')->textInput() ?>
<?= $form->field($model, 'Year')->dropDownList(Yii::$app->params['yearSelector']) ?>
<?= $form->field($model, 'Season')->dropDownList(['Fall' => 'Fall', 'Spring' => 'Spring', 'Summer' => 'Summer']) ?>
<div class="button-container">
    <?= Html::submitButton(Html::tag('i', '', ['class' => 'glyphicon glyphicon-refresh spin hidden']) . ' submit', ['class' => 'btn btn-success', 'id' => 'modal-form-submit']) ?>
    <?= Html::button('close', ['data-dismiss' => "modal", 'class' => 'btn btn-danger']) ?>
</div>
<?php ActiveForm::end(); ?>

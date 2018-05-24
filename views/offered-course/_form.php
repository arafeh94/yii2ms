<?php
/**
 * Created by PhpStorm.
 * User: Arafeh
 * Date: 5/16/2018
 * Time: 3:38 PM
 */

/**
 * @var $campuses \app\models\Campus[]
 * @var $semesters \app\models\Semester[]
 * @var $instructors \app\models\Instructor[]
 * @var $courses \app\models\Course[]
 */

use app\models\OfferedCourse;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Alert;
use yii\bootstrap\Html;
use yii\helpers\ArrayHelper;

if (!isset($model)) $model = new OfferedCourse();
?>


<?php if (isset($saved) && $saved): ?>
    <?= Alert::widget(['id' => 'form-state-alert', 'body' => 'saved', 'options' => ['class' => 'alert-info']]) ?>
    <script>if (window.gridControl) window.gridControl.shouldRefresh = true</script>
    <script>if (window.modalControl) window.modalControl.close()</script>
<?php endif; ?>

<?php $form = ActiveForm::begin([
    'id' => 'model-form',
    'action' => ['offered-course/update'],
    'options' => ['data-pjax' => '']
]) ?>
<?= $form->field($model, 'OfferedCourseId')->hiddenInput()->label(false) ?>
<?= $form->field($model, 'CampusId')->dropDownList(ArrayHelper::map($campuses, 'CampusId', 'Name')) ?>
<?= $form->field($model, 'SemesterId')->dropDownList(ArrayHelper::map($semesters, 'SemesterId', function ($model) {
    return $model->season->Name . ' - ' . $model->Year;
})) ?>
<?= $form->field($model, 'CourseId')->dropDownList(ArrayHelper::map($courses, 'CourseId', 'Name')) ?>
<?= $form->field($model, 'InstructorId')->dropDownList(ArrayHelper::map($instructors, 'InstructorId', function ($model) {
    return $model->FirstName . ' ' . $model->LastName;
})) ?>
<?= $form->field($model, 'CRN')->textInput(['type' => 'number']) ?>
<?= $form->field($model, 'Section')->textInput(['type' => 'number']) ?>
<div class="button-container">
    <?= Html::submitButton(Html::tag('i', '', ['class' => 'glyphicon glyphicon-refresh spin hidden']) . ' submit', ['class' => 'btn btn-success', 'id' => 'modal-form-submit']) ?>
    <?= Html::button('close', ['data-dismiss' => "modal", 'class' => 'btn btn-danger']) ?>
</div>
<?php ActiveForm::end(); ?>

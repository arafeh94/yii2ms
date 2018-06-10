<?php
/**
 * Created by PhpStorm.
 * User: Arafeh
 * Date: 5/16/2018
 * Time: 3:38 PM
 */

/** @var $model StudentCourseEnrollment */
/** @var $student Student */

/** @var $offeredCourses \app\models\OfferedCourse[] */

use app\models\Student;
use app\models\StudentCourseEnrollment;
use kartik\widgets\Select2;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Alert;
use yii\bootstrap\Html;
use yii\helpers\ArrayHelper;

if (!isset($model)) $model = new StudentCourseEnrollment();
?>

<?php if (isset($saved) && $saved): ?>
    <?= Alert::widget(['id' => 'form-state-alert', 'body' => 'saved', 'options' => ['class' => 'alert-info']]) ?>
    <script>if (window.gridControl) window.gridControl.shouldRefresh = true</script>
    <script>if (window.modalControl) window.modalControl.close()</script>
<?php endif; ?>

<?php $form = ActiveForm::begin([
    'id' => 'model-form',
    'action' => ['enrollment/update', 'student' => $student->UniversityId],
    'options' => ['data-pjax' => '']
]) ?>
<?= $form->field($model, 'StudentCourseEnrollmentId')->hiddenInput()->label(false) ?>
<?= $form->field($model, 'StudentSemesterEnrollmentId')->hiddenInput([
    'data-add-value' => $student->studentSemesterEnrollmentForCurrentSemester->StudentSemesterEnrollmentId
])->label(false) ?>

<?= $form->field($model, 'SchoolId')->widget(Select2::classname(), [
    'data' => ArrayHelper::map($offeredCourses, 'OfferedCourseId', function ($model) {
        return $model->CRN . ' - ' . $model->course->Letter;
    }),
    'options' => ['placeholder' => ''],
    'pluginOptions' => [
        'allowClear' => true
    ],
])->label('Name'); ?>

<div class="button-container">
    <?= Html::submitButton(Html::tag('i', '', ['class' => 'glyphicon glyphicon-refresh spin hidden']) . ' submit', ['class' => 'btn btn-success', 'id' => 'modal-form-submit']) ?>
    <?= Html::button('close', ['data-dismiss' => "modal", 'class' => 'btn btn-danger']) ?>
</div>
<?php ActiveForm::end(); ?>

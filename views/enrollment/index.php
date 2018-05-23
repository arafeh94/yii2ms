<?php
/* @var $this yii\web\View */
/** @var $isEnrolledInSemester bool */
/** @var $student Student */
/** @var $studentSemesterEnrollment StudentSemesterEnrollment  */

use app\components\ModalForm;
use app\models\Cycle;
use app\models\OfferedCourse;
use app\models\providers\CycleDataProvider;
use app\models\Student;
use app\models\StudentSemesterEnrollment;
use kartik\grid\GridView;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

if (!isset($studentSemesterEnrollment)) $studentSemesterEnrollment = new StudentSemesterEnrollment();

$newEnrollment = $studentSemesterEnrollment == null;
if ($isEnrolledInSemester) :
echo ModalForm::widget([
    'formPath' => '@app/views/enrollment/_form',
    'title' => 'Enrollments',
    'formParams' => [
        'offeredCourses' => OfferedCourse::find()->with('course')->active()->all(),
        'student' => $student
    ]
]);
endif;

?>



<?php $form2 = ActiveForm::begin([
    'method' => 'post',
    'id' => 'StudentSemesterEnrollment',
]); ?>
<?= $form2->field($studentSemesterEnrollment, 'StudentSemesterEnrollmentId')->hiddenInput()->label(false) ?>
<?php if (!$newEnrollment) : ?>
    <?= $form2->field($studentSemesterEnrollment, 'StudentId')->hiddenInput()->label(false) ?>
    <?= $form2->field($studentSemesterEnrollment, 'SemesterId')->hiddenInput()->label(false) ?>
<?php endif; ?>

<?php if (!$isEnrolledInSemester) : ?>
    <?= Html::submitButton('Enroll in Current Semester', ['class' => 'btn btn-success']) ?>
<?php else : ?>
    <?= Html::submitButton('Drop Current Semester', ['class' => 'btn btn-danger']) ?>
<?php endif; ?>
<?php ActiveForm::end() ?>

<br>
<?php if ($isEnrolledInSemester) :?>
<?= \app\components\GridViewBuilder::render($provider, 'Enrollments') ?>
<?php endif;?>

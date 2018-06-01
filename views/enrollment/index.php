<?php
/* @var $this yii\web\View */
/** @var $isEnrolledInSemester bool */
/** @var $student Student */

/** @var $studentSemesterEnrollment StudentSemesterEnrollment */

/** @var $currentSemester \app\models\Semester|null */

use app\components\ModalForm;
use app\models\Cycle;
use app\models\OfferedCourse;
use app\models\providers\CycleDataProvider;
use app\models\Student;
use app\models\StudentSemesterEnrollment;
use kartik\grid\GridView;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Alert;
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

<?php if ($currentSemester): ?>
    <?php $form = ActiveForm::begin([
        'method' => 'get',
        'action' => ["enrollment/enroll?studentId=$student->StudentId"],
        'id' => 'StudentSemesterEnrollment',
    ]); ?>
    <?php if (!$isEnrolledInSemester) : ?>
        <?= Html::submitButton('Enroll in Current Semester', ['class' => 'btn btn-success']) ?>
    <?php else : ?>
        <?= Html::submitButton('Drop Current Semester', ['class' => 'btn btn-danger']) ?>
    <?php endif; ?>
    <?php ActiveForm::end() ?>
<?php else: ?>
    <?php $link = Html::a('create one', ['term/index']); ?>
    <?= Alert::widget(['body' => "No term selected, <b>$link?</b>", 'closeButton' => false, 'options' => ['class' => 'alert-danger']]) ?>
<?php endif; ?>


<br>
<?php if ($isEnrolledInSemester) : ?>
    <?= \app\components\GridViewBuilder::render($provider, 'Enrollments') ?>
<?php endif; ?>

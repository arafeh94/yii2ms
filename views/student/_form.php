<?php
/**
 * Created by PhpStorm.
 * User: Arafeh
 * Date: 5/16/2018
 * Time: 3:38 PM
 */

/** @var $model Student */

/** @var $cycles Cycle[] */
/** @var $majors Major[] */

use app\models\Cycle;
use app\models\Major;
use app\models\Student;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Alert;
use yii\bootstrap\Html;
use yii\helpers\ArrayHelper;
use yii\jui\DatePicker;

if (!isset($model)) $model = new Student();
?>


<?php if (isset($saved) && $saved): ?>
    <?= Alert::widget(['id' => 'form-state-alert', 'body' => 'saved', 'options' => ['class' => 'alert-info']]) ?>
    <script>if (window.gridControl) window.gridControl.shouldRefresh = true</script>
    <script>if (window.modalControl) window.modalControl.close()</script>
<?php endif; ?>

<?php $form = ActiveForm::begin([
    'id' => 'model-form',
    'action' => ['student/update'],
    'options' => ['data-pjax' => '']
]) ?>
<?= $form->field($model, 'StudentId')->hiddenInput()->label(false) ?>

<ul class="nav nav-tabs" style="margin-bottom: 10px">
    <li class="active"><a data-toggle="tab" href="#personal-info">Personal</a></li>
    <li><a data-toggle="tab" href="#academic-status">Academic</a></li>
    <li><a data-toggle="tab" href="#leadership">Leadership</a></li>
    <li><a data-toggle="tab" href="#career">Career</a></li>
    <li><a data-toggle="tab" href="#post-graduation">Post Graduation</a></li>
</ul>

<div class="tab-content">
    <div id="personal-info" class="tab-pane fade in active">
        <?= $form->field($model, 'CycleId')->dropDownList(ArrayHelper::map($cycles, 'CycleId', 'Name'), ['prompt' => '']); ?>
        <?= $form->field($model, 'UniversityId')->textInput(); ?>
        <?= $form->field($model, 'CurrentMajor')->dropDownList(ArrayHelper::map($majors, 'MajorId', 'Name')); ?>
        <?= $form->field($model, 'FirstName')->textInput(); ?>
        <?= $form->field($model, 'FatherName')->textInput(); ?>
        <?= $form->field($model, 'LastName')->textInput(); ?>
        <?= $form->field($model, 'Gender')->dropDownList(['M' => 'Male', 'F' => 'Female'], ['prompt' => '']); ?>
        <?= $form->field($model, 'MeritStatus')->dropDownList(['Single' => 'Single', 'Engaged' => 'Engaged', 'Married' => 'Married'], ['prompt' => '']); ?>
        <?= $form->field($model, 'Email')->textInput(['type' => 'email']); ?>
        <?= $form->field($model, 'DOBYear')->textInput(['type' => 'number']); ?>
        <?= $form->field($model, 'DOBMonth')->textInput(); ?>
        <?= $form->field($model, 'PhoneNumber')->textInput(); ?>
        <?= $form->field($model, 'Village')->textInput(); ?>
        <?= $form->field($model, 'Caza')->textInput(); ?>
        <?= $form->field($model, 'Mouhafaza')->textInput(); ?>
        <?= $form->field($model, 'SchoolName')->textInput(); ?>
        <?= $form->field($model, 'TwelveGrade')->textInput(['type' => 'number']); ?>
        <?= $form->field($model, 'TenGrade')->textInput(['type' => 'number']); ?>
        <?= $form->field($model, 'ElevenGrade')->textInput(['type' => 'number']); ?>
        <?= $form->field($model, 'IDPCompleted')->dropDownList(Yii::$app->params['booleanSelector'], ['prompt' => '']); ?>
        <?= $form->field($model, 'EnglishExamScore')->textInput(['type' => 'number']); ?>
        <?= $form->field($model, 'SEESATScores')->textInput(['type' => 'number']); ?>
        <?= $form->field($model, 'HasLaptop')->dropDownList(Yii::$app->params['booleanSelector'], ['prompt' => '']); ?>
        <?= $form->field($model, 'LaptopSerialNumber')->textInput(); ?>
        <?= $form->field($model, 'ExpectedGraduation')->textInput(); ?>
        <?= $form->field($model, 'AdmissionMajor')->textInput(); ?>
        <?= $form->field($model, 'AdmissionSemester')->textInput(); ?>
        <?= $form->field($model, 'AcademicCoordinator')->textInput(); ?>
        <?= $form->field($model, 'StudentMentor')->textInput(); ?>
        <?= $form->field($model, 'BankAccount')->textInput(); ?>
        <?= $form->field($model, 'SummersTakenCount')->textInput(['type' => 'number']); ?>
        <?= $form->field($model, 'EligibilitySummer')->dropDownList(Yii::$app->params['booleanSelector'], ['prompt' => '']); ?>
        <?= $form->field($model, 'ReferredToCounselor')->dropDownList(Yii::$app->params['booleanSelector'], ['prompt' => '']); ?>
        <?= $form->field($model, 'CSPCompleted')->dropDownList(Yii::$app->params['booleanSelector'], ['prompt' => '']); ?>
        <?= $form->field($model, 'SchoolBackground')->textInput(); ?>
        <?= $form->field($model, 'CurrentEnrollmentStatus')->dropDownList(['Graduated' => 'Graduated', 'Enrolled' => 'Enrolled', 'DroppedOut' => 'DroppedOut', 'Failed On Time' => 'Failed On Time'], ['prompt' => '']); ?>
        <?= $form->field($model, 'IsGraduated')->dropDownList(Yii::$app->params['booleanSelector']); ?>
        <?= $form->field($model, 'HousingTransportAllowance')->textInput(); ?>
        <?= $form->field($model, 'PreparatorySemester')->dropDownList(Yii::$app->params['booleanSelector'], ['prompt' => '']); ?>
        <?= $form->field($model, 'StudentMOUSigned')->dropDownList(Yii::$app->params['booleanSelector'], ['prompt' => '']); ?>
        <?= $form->field($model, 'IsDataEntryComplete')->dropDownList(Yii::$app->params['booleanSelector'], ['prompt' => '']); ?>
        <?= $form->field($model, 'IsInitialVettingDone')->dropDownList(Yii::$app->params['booleanSelector'], ['prompt' => '']); ?>
    </div>
    <div id="academic-status" class="tab-pane fade">
        <?= $form->field($model, 'OverallImpression')->dropDownList(['Excellent' => 'Excellent', 'Good' => 'Good', 'Fair' => 'Fair', 'Weak' => 'Weak', 'Fail' => 'Fail'], ['prompt' => '']); ?>
        <?= $form->field($model, 'Faculty')->textInput(); ?>
        <?= $form->field($model, 'ConditionsChangeMajor')->textInput(); ?>
        <?= $form->field($model, 'TD')->dropDownList(Yii::$app->params['booleanSelector'], ['prompt' => '']); ?>
        <?= $form->field($model, 'EnrolledDoubleMajor')->dropDownList(Yii::$app->params['booleanSelector'], ['prompt' => '']); ?>
        <?= $form->field($model, 'EnrolledMajorMinor')->dropDownList(Yii::$app->params['booleanSelector'], ['prompt' => '']); ?>
        <?= $form->field($model, 'Probation')->dropDownList(Yii::$app->params['booleanSelector'], ['prompt' => '']); ?>
        <?= $form->field($model, 'ProbationRemovalDeadline')->textInput(); ?>
        <?= $form->field($model, 'Issues')->textInput(); ?>
    </div>
    <div id="leadership" class="tab-pane fade">
        <?= $form->field($model, 'LeadershipTraining')->textInput(); ?>
        <?= $form->field($model, 'CivicEngagement')->textInput(); ?>
        <?= $form->field($model, 'CommunityService')->textInput(); ?>
        <?= $form->field($model, 'USPCompetition')->textInput(); ?>
        <?= $form->field($model, 'StudentClub')->textInput(); ?>
        <?= $form->field($model, 'NameOfClub')->textInput(); ?>
    </div>
    <div id="career" class="tab-pane fade">
        <?= $form->field($model, 'Internship')->textInput(); ?>
        <?= $form->field($model, 'Duration')->textInput(); ?>
        <?= $form->field($model, 'InternshipHost')->textInput(); ?>
        <?= $form->field($model, 'EngagedWorkshops')->textInput(); ?>
        <?= $form->field($model, 'Certificate')->dropDownList(Yii::$app->params['booleanSelector'], ['prompt' => '']); ?>
        <?= $form->field($model, 'EngagedSoftSkills')->textInput(); ?>
        <?= $form->field($model, 'EngagedEntrepreneurship')->textInput(); ?>
    </div>
    <div id="post-graduation" class="tab-pane fade">
        <?= $form->field($model, 'EmploymentStatus')->textInput(); ?>
        <?= $form->field($model, 'EmploymentLocation')->textInput(); ?>
        <?= $form->field($model, 'StartOfEmployment')->widget(DatePicker::className(), ['dateFormat' => Yii::$app->params['dateFormat'], 'options' => ['class' => 'form-control']]); ?>
        <?= $form->field($model, 'IsFullTimePosition')->dropDownList(Yii::$app->params['booleanSelector'], ['prompt' => '']); ?>
        <?= $form->field($model, 'DateOfPhoneCall')->widget(DatePicker::className(), ['dateFormat' => Yii::$app->params['dateFormat'], 'options' => ['class' => 'form-control']]); ?>
        <?= $form->field($model, 'PhoneCallMadeBy')->textInput(); ?>
        <?= $form->field($model, 'GraduateStudies')->textInput(); ?>
        <?= $form->field($model, 'GraduateStudiesLocation')->textInput(); ?>
        <?= $form->field($model, 'RemarkableAchievements')->textInput(); ?>
    </div>
</div>
<div class="button-container">
    <?= Html::submitButton(Html::tag('i', '', ['class' => 'glyphicon glyphicon-refresh spin hidden']) . ' submit', ['class' => 'btn btn-success', 'id' => 'modal-form-submit']) ?>
    <?= Html::button('close', ['data-dismiss' => "modal", 'class' => 'btn btn-danger']) ?>
</div>
<?php ActiveForm::end(); ?>

<?php
/**
 * Created by PhpStorm.
 * User: Arafeh
 * Date: 5/18/2018
 * Time: 6:20 PM
 */

use app\components\FormInputColumn;
use app\models\User;
use kartik\grid\DataColumn;
use kartik\grid\EditableColumn;
use yii\bootstrap\Alert;
use yii\data\ArrayDataProvider;

/** @var \app\models\StudentCourseEvaluation [] $evaluations */
/** @var \app\models\InstructorEvaluationEmail $instructorEvaluationEmail */
/** @var $enrollments [] */
\app\components\Tools::console($enrollments);
?>

    <h3>Hello
        <?= $instructorEvaluationEmail->instructor->Title . '. ' . $instructorEvaluationEmail->instructor->FirstName . ' ' . $instructorEvaluationEmail->instructor->LastName ?>
    </h3>

<?php if ($instructorEvaluationEmail->DateFilled && Yii::$app->user->isGuest): ?>
    <?= Alert::widget([
        'options' => [
            'class' => 'alert-info',
        ],
        'body' => 'Evaluation Submitted, thank you for your time.',
    ]); ?>
<?php else : ?>

    <?php $form = \yii\bootstrap\ActiveForm::begin([
        'id' => 'eval-form'
    ]); ?>

    <?php $columns = [
        [
            'attribute' => 'course',
            'value' => function ($model) use ($enrollments) {
                foreach ($enrollments as $enrollment) {
                    if ($enrollment['StudentCourseEnrollmentId'] == $model->StudentCourseEnrollmentId) {
                        return $enrollment['CourseName'];
                    }
                }
                return '???';
            },
            'group' => true,
            'groupedRow' => true,
            'groupOddCssClass' => 'kv-grouped-row',
            'groupEvenCssClass' => 'kv-grouped-row',
        ],
        [
            'attribute' => 'cycle',
            'value' => function ($model) use ($enrollments) {
                foreach ($enrollments as $enrollment) {
                    if ($enrollment['StudentCourseEnrollmentId'] == $model->StudentCourseEnrollmentId) {
                        return $enrollment['CycleName'];
                    }
                }
                return '???';
            },
        ],
        [
            'attribute' => 'sec',
            'value' => function ($model) use ($enrollments) {
                foreach ($enrollments as $enrollment) {
                    if ($enrollment['StudentCourseEnrollmentId'] == $model->StudentCourseEnrollmentId) {
                        return $enrollment['Section'];
                    }
                }
                return '???';
            },
        ],
        [
            'class' => DataColumn::className(),
            'attribute' => 'student',
            'contentOptions' => ['class' => 'text-center'],
            'headerOptions' => ['class' => 'text-center'],
            'width' => '120px',
            'value' => function ($model) use ($enrollments) {
                foreach ($enrollments as $enrollment) {
                    if ($enrollment['StudentId'] == $model->StudentId) {
                        return $enrollment['FirstName'] . ' ' . $enrollment['LastName'];
                    }
                }
                return '???';
            }
        ],
        [
            'class' => FormInputColumn::className(),
            'attribute' => 'StudentCourseEvaluationId',
            'form' => $form,
            'hidden' => true,
            'config' => ['type' => 'number'],
        ],
        [
            'class' => FormInputColumn::className(),
            'attribute' => 'StudentCourseEnrollmentId',
            'form' => $form,
            'hidden' => true,
            'config' => ['type' => 'number'],
        ],
        [
            'class' => FormInputColumn::className(),
            'attribute' => 'InstructorEvaluationEmailId',
            'form' => $form,
            'hidden' => true,
            'config' => ['type' => 'number',],
        ],
        [
            'class' => FormInputColumn::className(),
            'attribute' => 'StudentId',
            'form' => $form,
            'hidden' => true,
            'config' => ['type' => 'number'],
        ],
        [
            'label' => '#Absence',
            'class' => FormInputColumn::className(),
            'attribute' => 'NumberOfAbsences',
            'form' => $form,
            'config' => ['type' => 'number'],
            'contentOptions' => ['style' => 'min-width:80px'],
            'pageSummary' => '<u>Step1</u> Insert number of absences',
            'pageSummaryOptions' => ['style' => 'text-align:center']
        ],
        [
            'label' => 'LetterGrade',
            'class' => DataColumn::className(),
            'attribute' => 'Grade',
            'format' => 'raw',
            'value' => function ($model, $key, $index) use ($form) {
                return $form->field($model, "[{$index}]Grade")->dropDownList(Yii::$app->params['gpaSelector'], [
                    'prompt' => ''
                ])->label(false);
            },
            'pageSummary' => '<u>Step2</u> Insert the letter grade',
            'pageSummaryOptions' => ['style' => 'text-align:center']
        ],
        [
            'class' => FormInputColumn::className(),
            'attribute' => 'Exam1',
            'form' => $form,
            'config' => ['type' => 'number'],
            'contentOptions' => ['style' => 'min-width:80px'],
        ],
        [
            'class' => FormInputColumn::className(),
            'attribute' => 'Exam2',
            'form' => $form,
            'config' => ['type' => 'number'],
            'contentOptions' => ['style' => 'min-width:80px'],
        ],
        [
            'class' => FormInputColumn::className(),
            'attribute' => 'Final',
            'form' => $form,
            'config' => ['type' => 'number'],
            'contentOptions' => ['style' => 'min-width:80px'],
        ],
        [
            'class' => FormInputColumn::className(),
            'attribute' => 'HomeWork',
            'label' => 'HW',
            'form' => $form,
            'config' => ['type' => 'number'],
            'contentOptions' => ['style' => 'min-width:80px'],
        ],
        [
            'class' => FormInputColumn::className(),
            'attribute' => 'Other',
            'form' => $form,
            'contentOptions' => ['style' => 'min-width:120px'],
        ],
        [
            'class' => FormInputColumn::className(),
            'attribute' => 'Other2',
            'form' => $form,
            'contentOptions' => ['style' => 'min-width:120px'],
        ],
        [
            'class' => FormInputColumn::className(),
            'attribute' => 'Other3',
            'form' => $form,
            'contentOptions' => ['style' => 'min-width:120px'],
        ],
        [
            'label' => 'Participation',
            'class' => DataColumn::className(),
            'attribute' => 'Participation',
            'contentOptions' => ['style' => 'min-width:150px'],
            'format' => 'raw',
            'value' => function ($model, $key, $index) use ($form) {
                return $form->field($model, "[{$index}]Participation")->dropDownList(Yii::$app->params['behaviorSelector'], [
                    'prompt' => ''
                ])->label(false);
            }
        ],
        [
            'label' => 'Effort',
            'class' => DataColumn::className(),
            'attribute' => 'Effort',
            'contentOptions' => ['style' => 'min-width:150px'],
            'format' => 'raw',
            'value' => function ($model, $key, $index) use ($form) {
                return $form->field($model, "[{$index}]Effort")->dropDownList(Yii::$app->params['behaviorSelector'], [
                    'prompt' => ''
                ])->label(false);
            }
        ],
        [
            'label' => 'Attitude',
            'class' => DataColumn::className(),
            'attribute' => 'Attitude',
            'contentOptions' => ['style' => 'min-width:150px'],
            'format' => 'raw',
            'value' => function ($model, $key, $index) use ($form) {
                return $form->field($model, "[{$index}]Attitude")->dropDownList(Yii::$app->params['behaviorSelector'], [
                    'prompt' => ''
                ])->label(false);
            }
        ],
        [
            'label' => 'Evaluation',
            'class' => DataColumn::className(),
            'attribute' => 'Evaluation',
            'contentOptions' => ['style' => 'min-width:180px'],
            'format' => 'raw',
            'value' => function ($model, $key, $index) use ($form) {
                return $form->field($model, "[{$index}]Evaluation")->dropDownList(Yii::$app->params['evaluationSelector'], [
                    'prompt' => ''
                ])->label(false);
            }
        ],
        [
            'class' => FormInputColumn::className(),
            'attribute' => 'InstructorNotes',
            'form' => $form,
            'contentOptions' => ['style' => 'min-width:200px'],
        ],
        [
            'label' => 'Withdraw',
            'class' => DataColumn::className(),
            'attribute' => 'Withdraw',
            'contentOptions' => ['style' => 'min-width:180px'],
            'format' => 'raw',
            'value' => function ($model, $key, $index) use ($form) {
                return $form->field($model, "[{$index}]Withdraw")->dropDownList(Yii::$app->params['withdrawSelector'], [
                    'prompt' => ''
                ])->label(false);
            }
        ],
    ]
    ?>

    <?php if (!Yii::$app->user->isGuest): ?>
        <?php if (Yii::$app->user->identity->Type === User::$ADMIN): ?>
            <?php $columns[] = [
                'class' => FormInputColumn::className(),
                'attribute' => 'AdminNote',
                'form' => $form,
                'contentOptions' => ['style' => 'min-width:120px'],
            ] ?>
        <?php elseif (Yii::$app->user->identity->Type === User::$USER): ?>
            <?php $columns[] = [
                'class' => FormInputColumn::className(),
                'attribute' => 'UserNote',
                'form' => $form,
                'contentOptions' => ['style' => 'min-width:120px'],
            ] ?>
        <?php endif ?>
    <?php endif ?>
    <?= \kartik\grid\GridView::widget([
        'dataProvider' => new ArrayDataProvider(['allModels' => $evaluations]),
        'pjax' => false,
        'resizableColumns' => false,
        'columns' => $columns,
        'showPageSummary' => false,
    ]);
    ?>
    <?= \yii\bootstrap\Html::submitButton('submit', ['class' => 'btn btn-danger']) ?>
    <?php \yii\bootstrap\ActiveForm::end(); ?>

<?php endif; ?>
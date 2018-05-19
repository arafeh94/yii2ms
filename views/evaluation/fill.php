<?php
/**
 * Created by PhpStorm.
 * User: Arafeh
 * Date: 5/18/2018
 * Time: 6:20 PM
 */

use kartik\grid\EditableColumn;
use yii\bootstrap\Alert;
use yii\data\ArrayDataProvider;

/** @var \app\models\StudentCourseEvaluation [] $evaluations */
/** @var \app\models\InstructorEvaluationEmail $instructorEvaluationEmail */
/** @var $enrollments [] */
?>

<?php if ($instructorEvaluationEmail->DateFilled): ?>
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

    <?= \kartik\grid\GridView::widget([
        'dataProvider' => new ArrayDataProvider(['allModels' => $evaluations]),
        'pjax' => false,
        'columns' => [
            [
                'attribute' => 'course',
                'value' => function ($model) use ($enrollments) {
                    foreach ($enrollments as $enrollment) {
                        if ($enrollment['StudentCourseEnrollmentId'] == $model->StudentCourseEnrollmentId) {
                            return $enrollment['Name'];
                        }
                    }
                    return '???';
                },
                'group' => true,
                'groupedRow' => true,                    // move grouped column to a single grouped row
                'groupOddCssClass' => 'kv-grouped-row',  // configure odd group cell css class
                'groupEvenCssClass' => 'kv-grouped-row', // configure even group cell css class
            ],
            [
                'class' => \kartik\grid\DataColumn::className(),
                'attribute' => 'student',
                'contentOptions' => ['class' => 'text-center'],
                'headerOptions' => ['class' => 'text-center'],
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
                'class' => \app\components\FormInputColumn::className(),
                'attribute' => 'StudentCourseEvaluationId',
                'form' => $form,
                'visible' => false,
                'config' => ['type' => 'number', 'disabled' => 'disabled', 'readonly' => 'readonly'],
            ],
            [
                'class' => \app\components\FormInputColumn::className(),
                'attribute' => 'StudentCourseEnrollmentId',
                'form' => $form,
                'visible' => false,
                'config' => ['type' => 'number', 'disabled' => 'disabled', 'readonly' => 'readonly'],
            ],
            [
                'class' => \app\components\FormInputColumn::className(),
                'attribute' => 'InstructorEvaluationEmailId',
                'form' => $form,
                'visible' => false,
                'config' => ['type' => 'number', 'disabled' => 'disabled', 'readonly' => 'readonly'],
            ],
            [
                'class' => \app\components\FormInputColumn::className(),
                'attribute' => 'StudentId',
                'form' => $form,
                'visible' => false,
                'config' => ['type' => 'number', 'disabled' => 'disabled', 'readonly' => 'readonly'],
            ],
            [
                'class' => \app\components\FormInputColumn::className(),
                'attribute' => 'NumberOfAbsences',
                'form' => $form,
                'config' => ['type' => 'number'],
            ],
            [
                'class' => \app\components\FormInputColumn::className(),
                'attribute' => 'Grade',
                'form' => $form,
                'config' => ['type' => 'number'],
            ],
            [
                'class' => \app\components\FormInputColumn::className(),
                'attribute' => 'HomeWork',
                'form' => $form,
                'config' => ['type' => 'number'],
            ],
            [
                'class' => \app\components\FormInputColumn::className(),
                'attribute' => 'Participation',
                'form' => $form,
                'config' => ['type' => 'number'],
            ],
            [
                'class' => \app\components\FormInputColumn::className(),
                'attribute' => 'Effort',
                'form' => $form,
                'config' => ['type' => 'number'],
            ],
            [
                'class' => \app\components\FormInputColumn::className(),
                'attribute' => 'Attitude',
                'form' => $form,
                'config' => ['type' => 'number'],
            ],
            [
                'class' => \app\components\FormInputColumn::className(),
                'attribute' => 'Evaluation',
                'form' => $form,
                'config' => ['type' => 'number'],
            ],
            [
                'class' => \app\components\FormInputColumn::className(),
                'attribute' => 'InstructorNotes',
                'form' => $form,
            ],
            [
                'class' => \app\components\FormInputColumn::className(),
                'attribute' => 'UserNote',
                'form' => $form,
            ],
            [
                'class' => \app\components\FormInputColumn::className(),
                'attribute' => 'AdminNote',
                'form' => $form,
            ],
        ]
    ]);
    ?>
    <?= \yii\bootstrap\Html::submitButton('submit', ['class' => 'btn btn-danger']) ?>
    <?php \yii\bootstrap\ActiveForm::end(); ?>
<?php endif; ?>

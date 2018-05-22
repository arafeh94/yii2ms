<?php
/**
 * Created by PhpStorm.
 * User: Arafeh
 * Date: 5/18/2018
 * Time: 6:20 PM
 */

use app\components\FormInputColumn;
use kartik\grid\DataColumn;
use kartik\grid\EditableColumn;
use yii\bootstrap\Alert;
use yii\data\ArrayDataProvider;

/** @var \app\models\StudentCourseEvaluation [] $evaluations */
/** @var \app\models\InstructorEvaluationEmail $instructorEvaluationEmail */
/** @var $enrollments [] */
?>

<h3>Hello
    <?= $instructorEvaluationEmail->instructor->Title . '. ' . $instructorEvaluationEmail->instructor->FirstName . ' ' . $instructorEvaluationEmail->instructor->LastName ?>
</h3>

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
                'width' => '80px',
                'config' => ['type' => 'number'],
            ],
            [
                'label' => 'Grade',
                'class' => FormInputColumn::className(),
                'attribute' => 'Grade',
                'form' => $form,
                'width' => '80px',
                'config' => ['type' => 'number'],
            ],
//            [
//                'class' => DataColumn::className(),
//                'attribute' => 'Grade',
//                'width' => '90px',
//                'format' => 'raw',
//                'value' => function ($model, $key, $index) use ($form) {
//                    return $form->field($model, "[{$index}]Grade")->dropDownList(Yii::$app->params['gpaSelector'], [
//                        'prompt' => ''
//                    ])->label(false);
//                }
//            ],
            [
                'class' => FormInputColumn::className(),
                'attribute' => 'HomeWork',
                'form' => $form,
                'config' => ['type' => 'number'],
            ],
            [
                'class' => FormInputColumn::className(),
                'attribute' => 'Participation',
                'form' => $form,
                'config' => ['type' => 'text'],
            ],
            [
                'class' => FormInputColumn::className(),
                'attribute' => 'Effort',
                'form' => $form,
                'config' => ['type' => 'text'],
            ],
            [
                'class' => FormInputColumn::className(),
                'attribute' => 'Attitude',
                'form' => $form,
                'config' => ['type' => 'text'],
            ],
            [
                'class' => FormInputColumn::className(),
                'attribute' => 'Evaluation',
                'form' => $form,
                'config' => ['type' => 'number'],
            ],
            [
                'class' => FormInputColumn::className(),
                'attribute' => 'InstructorNotes',
                'form' => $form,
            ],
        ]
    ]);
    ?>
    <?= \yii\bootstrap\Html::submitButton('submit', ['class' => 'btn btn-danger']) ?>
    <?php \yii\bootstrap\ActiveForm::end(); ?>
<?php endif; ?>

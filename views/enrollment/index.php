<?php
/* @var $this yii\web\View */

use app\components\ModalForm;
use app\models\Cycle;
use app\models\OfferedCourse;
use app\models\providers\CycleDataProvider;
use kartik\grid\GridView;


echo ModalForm::widget([
    'formPath' => '@app/views/enrollment/_form',
    'title' => 'Enrollments',
    'formParams' => [
        'offeredCourses' => OfferedCourse::find()->with('course')->active()->all(),
        'student' => $student
    ]
]);

?>

<?= \app\components\GridViewBuilder::render($provider, 'Enrollments') ?>

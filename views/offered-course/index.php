<?php
/* @var $this yii\web\View */

use app\components\ModalForm;
use app\models\Campus;
use app\models\Course;
use app\models\Department;
use app\models\Instructor;
use app\models\providers\CycleDataProvider;
use app\models\School;
use app\models\Semester;
use kartik\grid\GridView;

echo ModalForm::widget(
    [
        'formPath' => '@app/views/offered-course/_form',
        'title' => 'Offered Course',
        'formParams' => [
            'campuses' => Campus::find()->active()->all(),
            'semesters' => Semester::find()->active()->all(),
            'instructors' => Instructor::find()->active()->all(),
            'courses' => Course::find()->active()->all(),
        ]
    ]
);

?>

<?= \app\components\GridViewBuilder::render($provider, 'Offered Courses') ?>

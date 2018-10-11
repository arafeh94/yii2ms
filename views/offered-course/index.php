<?php
/** @var $this yii\web\View */

/** @var $provider \app\models\providers\OfferedCourseDataProvider */

use app\components\ModalController;
use app\components\ModalForm;
use app\models\Campus;
use app\models\Course;
use app\models\Instructor;
use app\models\Semester;
use yii\bootstrap\Modal;

echo ModalForm::widget([
        'formPath' => '@app/views/offered-course/_form',
        'title' => 'Offered Course',
        'formParams' => [
            'campuses' => Campus::find()->active()->all(),
            'semesters' => Semester::find()->active()->all(),
            'instructors' => Instructor::find()->active()->all(),
            'courses' => Course::find()->active()->activated()->all(),
        ]
    ]
);

echo ModalController::widget([
    'title' => 'Confirm Delete',
    'size' => Modal::SIZE_LARGE
]);

?>

<?= \app\components\GridViewBuilder::render($provider, 'Offered Courses') ?>

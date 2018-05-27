<?php
/* @var $this yii\web\View */
/* @var $major Major */

/* @var $provider \app\models\providers\StudyPlanDataProvider */

use app\components\ModalForm;
use app\models\Major;

echo ModalForm::widget([
    'formPath' => '@app/views/study-plan/_form',
    'title' => 'Study Plan',
    'formParams' => [
        'model' => $model
    ]
]);

?>

<?= \app\components\GridViewBuilder::render($provider, "Study Plan for {$major->Name}") ?>

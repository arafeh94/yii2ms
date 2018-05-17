<?php
/* @var $this yii\web\View */

use app\components\ModalForm;
use app\models\providers\CycleDataProvider;
use app\models\School;
use kartik\grid\GridView;

echo ModalForm::widget([
    'formPath' => '@app/views/instructor/_form',
    'title' => 'Instructor',
]);

?>

<?= \app\components\GridViewBuilder::render($provider, 'Instructor') ?>

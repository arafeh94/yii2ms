<?php
/* @var $this yii\web\View */

use app\components\ModalForm;
use app\models\Cycle;
use app\models\Major;
use app\models\providers\CycleDataProvider;
use kartik\grid\GridView;

echo ModalForm::widget([
    'formPath' => '@app/views/student/_form',
    'title' => 'Student',
    'formParams' => [
        'cycles' => Cycle::find()->active()->all(),
        'majors' => Major::find()->active()->all()
    ]
]);

?>

<?= \app\components\GridViewBuilder::render($provider, 'Students') ?>

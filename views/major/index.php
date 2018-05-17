<?php
/* @var $this yii\web\View */

use app\components\ModalForm;
use app\models\Department;
use app\models\providers\CycleDataProvider;
use app\models\School;
use kartik\grid\GridView;

echo ModalForm::widget(
    [
        'formPath' => '@app/views/major/_form',
        'title' => 'Major',
        'formParams' => [
            'departments' => Department::find()->with('school')->active()->all()
        ]
    ]
);

?>

<?= \app\components\GridViewBuilder::render($provider, 'Major') ?>

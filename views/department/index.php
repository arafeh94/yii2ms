<?php
/* @var $this yii\web\View */

use app\components\ModalForm;
use app\models\providers\CycleDataProvider;
use app\models\School;
use kartik\grid\GridView;

echo ModalForm::widget(['formPath' => '@app/views/department/_form', 'title' => 'Department', 'formParams' => ['schools' => School::find()->active()->all()]]);

?>

<?= \app\components\GridViewBuilder::render($provider, 'Department') ?>

<?php
/* @var $this yii\web\View */

use app\components\ModalForm;
use app\models\providers\CycleDataProvider;
use kartik\grid\GridView;

echo ModalForm::widget(['formPath' => '@app/views/cycle/_form']);

?>

<?= \app\components\GridViewBuilder::render($provider, 'Cycle') ?>

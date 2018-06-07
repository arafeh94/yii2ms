<?php
/* @var $this yii\web\View */


use app\components\ModalForm;
use app\models\providers\CycleDataProvider;
use kartik\grid\GridView;

echo ModalForm::widget(['formPath' => '@app/views/term/_form', 'title' => 'Term']);

?>

<?= \app\components\GridViewBuilder::render($provider, 'Term') ?>

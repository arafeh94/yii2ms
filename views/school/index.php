<?php
/* @var $this yii\web\View */

use app\components\ModalForm;

echo ModalForm::widget(['formPath' => '@app/views/school/_form']);

?>

<?= \app\components\GridViewBuilder::render($provider, 'School') ?>

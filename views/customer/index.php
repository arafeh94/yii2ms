<?php
/* @var $this yii\web\View */

/* @var $provider \app\models\providers\CustomerDataProvider */

use app\components\ModalForm;
use app\models\Major;
use app\models\Project;

echo ModalForm::widget(['formPath' => '@app/views/customer/_form', 'title' => 'Customer',]);

?>

<?= \app\components\GridViewBuilder::render($provider, 'Customers') ?>

<?php
/* @var $this yii\web\View */

/* @var $provider \app\components\extensions\AppDataProvider */

use app\components\ModalForm;
use app\models\Major;
use app\models\Project;

echo ModalForm::widget([
    'formPath' => '@app/views/category/_form',
    'title' => 'Category'
]);

?>

<?= \app\components\GridViewBuilder::render($provider, 'Categories') ?>

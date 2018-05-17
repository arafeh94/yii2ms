<?php
/* @var $this yii\web\View */

/* @var $seasons \app\models\Season[] */

use app\components\ModalForm;
use app\models\providers\CycleDataProvider;
use kartik\grid\GridView;

echo ModalForm::widget(['formPath' => '@app/views/term/_form', 'title' => 'Term', 'formParams' => [
    'seasons' => $seasons
]]);

?>

<?= \app\components\GridViewBuilder::render($provider, 'Term') ?>

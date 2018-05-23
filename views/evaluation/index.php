<?php

/** @var \app\models\providers\EvaluationReportDataProvider $provider */

use kartik\grid\GridView;
use yii\bootstrap\Modal;
use yii\helpers\Html;

?>

<?= GridView::widget([
    'id' => 'gridview',
    'dataProvider' => $provider,
    'filterModel' => $provider->searchModel(),
    'columns' => $provider->gridColumns(),
    'autoXlFormat' => true,
    'export' => [
        'fontAwesome' => true,
        'showConfirmAlert' => false,
        'target' => GridView::TARGET_BLANK
    ],
    'toolbar' => [
        ['content' =>
            Html::button('<i class="glyphicon glyphicon-repeat"></i>', ['data-pjax' => 0, 'class' => 'btn btn-default', 'title' => Yii::t('app', 'Reset Grid'), 'onclick' => 'gridControl.reload(true)'])
        ],
        '{export}',
        '{toggleData}',
    ],
    'pjax' => true,
    'pjaxSettings' => [
        'options' => [
            'enablePushState' => false
        ]
    ],
    'panel' => [
        'type' => 'primary',
        'heading' => 'Evaluations'
    ]
]) ?>


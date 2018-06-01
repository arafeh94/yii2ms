<?php
/**
 * Created by PhpStorm.
 * User: Arafeh
 * Date: 5/31/2018
 * Time: 7:57 AM
 */

use kartik\grid\GridView;
use yii\bootstrap\Html;

/** @var \app\models\Student $student */
/** @var \app\models\providers\StudyPlanReportDataProvider $provider */
?>



<?= GridView::widget([
    'id' => 'gridview',
    'dataProvider' => $provider,
    'filterModel' => $provider->searchModel(),
    'columns' => $provider->gridColumns(),
    'hover' => true,
    'autoXlFormat' => true,
    'showPageSummary' => true,
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
        'heading' => "Study Plan for {$student->FirstName} {$student->LastName}"
    ]
]) ?>

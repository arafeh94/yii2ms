<?php
/**
 * Created by PhpStorm.
 * User: Arafeh
 * Date: 5/31/2018
 * Time: 7:57 AM
 */

use app\components\Queries;
use app\components\QueriesExecutor;
use kartik\grid\GridView;
use yii\bootstrap\Html;

/** @var \app\models\Student $student */
/** @var \app\models\providers\StudyPlanReportDataProvider $provider */

$requiredCredits = $student->major->RequiredCredits;
$passedCredits = QueriesExecutor::number(Queries::passedCredits($student));
$gradCredits = $requiredCredits - $passedCredits - $student->TransferredCredits;


?>

<?php
$tableSummary = $this->render('summary', [
    'requiredCredits' => $requiredCredits,
    'transferredCreditsDetails' => $student->TransferredCreditsDetails,
    'transferredCredits' => $student->TransferredCredits,
    'gradCredits' => $gradCredits < 0 ? 0 : $gradCredits,
    'passedCredits' => $passedCredits ? $passedCredits : 0,
]);


?>

<?= GridView::widget([
    'id' => 'gridview',
    'dataProvider' => $provider,
    'defaultPagination' => 'all',
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
    'exportConfig' => [
        GridView::PDF => Yii::$app->params['pdf']("$student->FirstName $student->LastName Study Plan"),
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
    ],
    'showFooter' => true,
    'beforeHeader' => [
        [
            'columns' => [
                [
                    'content' => 'University ID',
                    'options' => [
                        'colspan' => 2
                    ]
                ],
                [
                    'content' => "Student Name",
                    'options' => [
                        'colspan' => 3
                    ]
                ],
                [
                    'content' => "Major",
                    'options' => [
                        'colspan' => 2
                    ]
                ],
            ]
        ],
        [
            'columns' => [
                [
                    'content' => $student->UniversityId,
                    'options' => [
                        'colspan' => 2
                    ]
                ],
                [
                    'content' => "$student->FirstName $student->LastName",
                    'options' => [
                        'colspan' => 3
                    ]
                ],
                [
                    'content' => "{$student->major->Name}",
                    'options' => [
                        'colspan' => 2
                    ]
                ],
            ]
        ]

    ],
    'afterFooter' => [
        [
            'columns' => [
                [
                    'content' => '',
                    'options' => [
                        'colspan' => 6
                    ]
                ],
                [
                    'content' => $tableSummary,
                    'options' => [
                        'colspan' => 1
                    ]
                ],
            ]
        ]
    ]
]) ?>

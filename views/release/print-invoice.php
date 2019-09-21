<?php /** @noinspection ALL */

/**
 * Created by PhpStorm.
 * User: Arafeh
 * Date: 9/21/2019
 * Time: 3:47 PM
 */

/* @var $this \yii\web\View */
/* @var $invoices \app\models\Invoice[] */
/* @var $project \app\models\Project */
?>

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
      integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

<style>
    body {
        padding: 24px;
    }

    div .summary {
        display: none;
    }

    .introduction table td {
        padding: 6px;
    }

    .introduction {
        padding-bottom: 16px;
    }
</style>


<div class="introduction">

    <div style="position:absolute;width: 100%;right: 150px;text-align: right">
        image asdasdas
        <table style="position:absolute;right: 0px;">
            <tr>
                <td width="150px">ID PROJECT</td>
                <td><?= $project->id ?></td>
        </table>
        <?= $project->terms ?>
    </div>
    <div style="margin-bottom: 16px">
        <h1>Invoice</h1>
        <div>
            <table class="table table-borderless">
                <tr>
                    <td width="200px">Invoice Reference</td>
                    <td><?= 'samira' ?></td>
                </tr>
                <tr>
                    <td>Company</td>
                    <td><?= $project->company->name ?></td>
                </tr>
                <tr>
                    <td>PO Reference</td>
                    <td><?= $project->po_number ?></td>
                </tr>
            </table>
        </div>
    </div>


    <?= \kartik\grid\GridView::widget([
        'dataProvider' => new \yii\data\ArrayDataProvider(['allModels' => $invoices]),
        'columns' => ['ref', 'description', 'brand', 'quantity',
            ['attribute' => 'price', 'pageSummary' => function ($v) {
                return $v . 'QAR';
            }]],
        'showPageSummary' => true,
    ]) ?>
</div>
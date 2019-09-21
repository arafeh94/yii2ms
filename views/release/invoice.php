<?php

/**
 * Created by PhpStorm.
 * User: Arafeh
 * Date: 9/21/2019
 * Time: 2:49 PM
 */

use app\components\extensions\Search;
use kartik\form\ActiveForm;
use kartik\widgets\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $model Search */
/* @var $invoices \app\models\Invoice[] */
/* @var $project \app\models\Project */
?>

<?php $form = ActiveForm::begin(['id' => 'form', 'method' => 'get']) ?>
<?= $form->field($model, 'project_id')->label('Select Project')->widget(Select2::classname(), [
    'data' => ArrayHelper::map(\app\models\Project::find()->active()->all(), 'id', 'po_number'),
    'options' => ['placeholder' => '', 'onchange' => '$("#form").submit()'],
    'pluginOptions' => [
        'allowClear' => true
    ],
]); ?>
<?php ActiveForm::end(); ?>
<?= \kartik\grid\GridView::widget([
    'dataProvider' => new \yii\data\ArrayDataProvider(['allModels' => $invoices]),
    'columns' => ['ref', 'description', 'brand', 'quantity', 'price'],
]) ?>
<div style="width: 100%;text-align: right; margin-top: 12px">
    <?= \yii\bootstrap\Html::a('Print', ['release/print-invoice'], ['class' => 'btn btn-danger', 'target' => "_blank"]) ?>
</div>
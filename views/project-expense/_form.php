<?php
/**
 * Created by PhpStorm.
 * User: Arafeh
 * Date: 5/16/2018
 * Time: 3:38 PM
 */

/** @var $model \app\models\ProjectPayment */


use app\models\Invoice;
use app\models\ProjectExpense;
use app\models\ProjectPayment;
use kartik\widgets\Select2;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Alert;
use yii\bootstrap\Html;
use yii\helpers\ArrayHelper;
use yii\jui\DatePicker;

if (!isset($model)) $model = new ProjectExpense();
?>


<?php if (isset($saved) && $saved): ?>
    <?= Alert::widget(['id' => 'form-state-alert', 'body' => 'saved', 'options' => ['class' => 'alert-info']]) ?>
    <script>if (window.gridControl) window.gridControl.shouldRefresh = true</script>
    <script>if (window.modalControl) window.modalControl.close()</script>
<?php endif; ?>

<?php $form = ActiveForm::begin([
    'id' => 'model-form',
    'action' => ['project-expense/update'],
    'options' => ['data-pjax' => '']
]) ?>
<?= $form->field($model, 'id')->hiddenInput()->label(false) ?>
<?= $form->field($model, 'project_id')->widget(Select2::classname(), [
    'data' => ArrayHelper::map(\app\models\Project::find()->all(), 'id', 'po_number'),
    'options' => ['placeholder' => ''],
    'pluginOptions' => [
        'allowClear' => true
    ],
    'addon' => \app\components\Extensions::select2Add(['project/index'], 'Add Project')
]); ?>

<?= $form->field($model, 'employee_id')->widget(Select2::classname(), [
    'data' => ArrayHelper::map(\app\models\Employee::find()->all(), 'id', 'name'),
    'options' => ['placeholder' => ''],
    'pluginOptions' => [
        'allowClear' => true
    ],
    'addon' => \app\components\Extensions::select2Add(['employee/index'], 'Add Employee')
]); ?>
<?= $form->field($model, 'order_ref')->textInput() ?>
<?= $form->field($model, 'order_amount')->textInput() ?>
<?= $form->field($model, 'expense_code')->textInput() ?>
<?= $form->field($model, 'remark')->textInput() ?>
<?= $form->field($model, 'date_expense')->widget(DatePicker::className(), ['dateFormat' => 'y-M-d', 'options' => ['class' => 'form-control', 'autocomplete' => 'off']]) ?>

<div class="button-container">
    <?= Html::submitButton(Html::tag('i', '', ['class' => 'glyphicon glyphicon-refresh spin hidden']) . ' submit', ['class' => 'btn btn-success', 'id' => 'modal-form-submit']) ?>
    <?= Html::button('close', ['data-dismiss' => "modal", 'class' => 'btn btn-danger']) ?>
</div>
<?php ActiveForm::end(); ?>

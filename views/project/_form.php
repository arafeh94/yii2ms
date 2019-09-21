<?php
/**
 * Created by PhpStorm.
 * User: Arafeh
 * Date: 5/16/2018
 * Time: 3:38 PM
 */

/** @var $model Project */

use app\models\Project;
use kartik\widgets\Select2;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Alert;
use yii\bootstrap\Html;
use yii\helpers\ArrayHelper;
use yii\jui\DatePicker;

if (!isset($model)) $model = new Project();
?>


<?php if (isset($saved) && $saved): ?>
    <?= Alert::widget(['id' => 'form-state-alert', 'body' => 'saved', 'options' => ['class' => 'alert-info']]) ?>
    <script>if (window.gridControl) window.gridControl.shouldRefresh = true</script>
    <script>if (window.modalControl) window.modalControl.close()</script>
<?php endif; ?>

<?php $form = ActiveForm::begin([
    'id' => 'model-form',
    'action' => ['project/update'],
    'options' => ['data-pjax' => '']
]) ?>
<?= $form->field($model, 'id')->hiddenInput()->label(false) ?>
<?= $form->field($model, 'customer_id')->widget(Select2::classname(), [
    'data' => ArrayHelper::map(\app\models\Customer::find()->all(), 'id', 'name'),
    'options' => ['placeholder' => ''],
    'pluginOptions' => [
        'allowClear' => true
    ],
    'addon' => \app\components\Extensions::select2Add(['customer/index'], 'Add Customer')
]); ?>
<?= $form->field($model, 'category_id')->widget(Select2::classname(), [
    'data' => ArrayHelper::map(\app\models\Category::find()->all(), 'id', 'name'),
    'options' => ['placeholder' => ''],
    'pluginOptions' => [
        'allowClear' => true
    ],
    'addon' => \app\components\Extensions::select2Add(['category/index'], 'Add Category')
]); ?>
<?= $form->field($model, 'company_id')->widget(Select2::classname(), [
    'data' => ArrayHelper::map(\app\models\Company::find()->active()->all(), 'id', 'name'),
    'options' => ['placeholder' => ''],
    'pluginOptions' => [
        'allowClear' => true
    ],
    'addon' => \app\components\Extensions::select2Add(['company/index'], 'Add Company')
]); ?>
<?= $form->field($model, 'name')->textInput() ?>
<?= $form->field($model, 'priority')->textInput(['type' => 'number']) ?>
<?= $form->field($model, 'po_number')->textInput() ?>
<?= $form->field($model, 'order_value')->textInput(['type' => 'number']) ?>
<?= $form->field($model, 'terms')->textInput() ?>
<?= $form->field($model, 'status')->textInput() ?>
<?= $form->field($model, 'date_begin')->widget(DatePicker::className(), ['dateFormat' => 'yyyy-MM-dd', 'options' => ['class' => 'form-control', 'autocomplete' => 'off']]) ?>
<?= $form->field($model, 'date_end')->widget(DatePicker::className(), ['dateFormat' => 'yyyy-MM-dd', 'options' => ['class' => 'form-control', 'autocomplete' => 'off']]) ?>
<?= $form->field($model, 'notes')->textInput() ?>

<div class="button-container">
    <?= Html::submitButton(Html::tag('i', '', ['class' => 'glyphicon glyphicon-refresh spin hidden']) . ' submit', ['class' => 'btn btn-success', 'id' => 'modal-form-submit']) ?>
    <?= Html::button('close', ['data-dismiss' => "modal", 'class' => 'btn btn-danger']) ?>
</div>
<?php ActiveForm::end(); ?>

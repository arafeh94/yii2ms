<?php
/**
 * Created by PhpStorm.
 * User: Arafeh
 * Date: 5/16/2018
 * Time: 3:38 PM
 */

/** @var $model Department */

/** @var $schools School[] */

use app\models\Department;
use app\models\School;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Alert;
use yii\helpers\ArrayHelper;

if (!isset($model)) $model = new Department();
?>


<?php if (isset($saved) && $saved): ?>
    <?= Alert::widget(['id' => 'form-state-alert', 'body' => 'saved', 'options' => ['class' => 'alert-info']]) ?>
    <script>if (window.gridControl) window.gridControl.shouldRefresh = true</script>
<?php endif; ?>

<?php $form = ActiveForm::begin([
    'id' => 'model-form',
    'action' => ['department/update'],
    'options' => ['data-pjax' => '']
]) ?>
<?= $form->field($model, 'DepartmentId')->hiddenInput()->label(false) ?>
<?= $form->field($model, 'SchoolId')->dropDownList(ArrayHelper::map($schools,'SchoolId','Name'))?>
<?= $form->field($model, 'Name')->textInput() ?>
<?= \yii\bootstrap\Html::submitButton('submit', ['class' => 'btn btn-success']) ?>
<?= \yii\bootstrap\Html::button('close', ['data-dismiss' => "modal", 'class' => 'btn btn-danger', 'onclick' => 'modalFormClose()']) ?>
<?php ActiveForm::end(); ?>

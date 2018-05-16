<?php
/**
 * Created by PhpStorm.
 * User: Arafeh
 * Date: 5/16/2018
 * Time: 3:38 PM
 */


use app\models\Cycle;
use app\models\School;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Alert;

if (!isset($model)) $model = new School();
?>


<?php if (isset($saved) && $saved): ?>
    <?= Alert::widget(['id' => 'form-state-alert', 'body' => 'saved', 'options' => ['class' => 'alert-info']]) ?>
    <script>if (window.gridControl) window.gridControl.shouldRefresh = true</script>
<?php endif; ?>

<?php $form = ActiveForm::begin([
    'id' => 'model-form',
    'action' => ['school/update'],
    'options' => ['data-pjax' => '']
]) ?>
<?= $form->field($model, 'SchoolId')->hiddenInput()->label(false) ?>
<?= $form->field($model, 'Name')->textInput() ?>
<?= \yii\bootstrap\Html::submitButton('submit', ['class' => 'btn btn-success']) ?>
<?= \yii\bootstrap\Html::button('close', ['data-dismiss' => "modal", 'class' => 'btn btn-danger', 'onclick' => 'modalFormClose()']) ?>
<?php ActiveForm::end(); ?>

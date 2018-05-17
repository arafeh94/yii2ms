<?php
/**
 * Created by PhpStorm.
 * User: Arafeh
 * Date: 5/16/2018
 * Time: 3:38 PM
 */

/** @var $model Course */

/** @var $majors \app\models\Major[] */

use app\models\Course;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Alert;
use yii\helpers\ArrayHelper;

if (!isset($model)) $model = new Course();
?>


<?php if (isset($saved) && $saved): ?>
    <?= Alert::widget(['id' => 'form-state-alert', 'body' => 'saved', 'options' => ['class' => 'alert-info']]) ?>
    <script>if (window.gridControl) window.gridControl.shouldRefresh = true</script>
<?php endif; ?>

<?php $form = ActiveForm::begin([
    'id' => 'model-form',
    'action' => ['course/update'],
    'options' => ['data-pjax' => '']
]) ?>
<?= $form->field($model, 'CourseId')->hiddenInput()->label(false) ?>
<?= $form->field($model, 'MajorId')->dropDownList(ArrayHelper::map($majors, 'MajorId', 'Name'))->label('Major') ?>
<?= $form->field($model, 'Name')->textInput() ?>
<?= $form->field($model, 'Number')->textInput(['type' => 'number']) ?>
<?= $form->field($model, 'Credits')->textInput(['type' => 'number']) ?>
<?= \yii\bootstrap\Html::submitButton('submit', ['class' => 'btn btn-success']) ?>
<?= \yii\bootstrap\Html::button('close', ['data-dismiss' => "modal", 'class' => 'btn btn-danger', 'onclick' => 'modalFormClose()']) ?>
<?php ActiveForm::end(); ?>

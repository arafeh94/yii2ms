<?php
/**
 * Created by PhpStorm.
 * User: Arafeh
 * Date: 5/16/2018
 * Time: 3:38 PM
 */

/** @var $model Semester */

/** @var $seasons Season[] */

use app\models\Season;
use app\models\Semester;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Alert;
use yii\helpers\ArrayHelper;
use yii\jui\DatePicker;

if (!isset($model)) $model = new Semester();
?>


<?php if (isset($saved) && $saved): ?>
    <?= Alert::widget(['id' => 'form-state-alert', 'body' => 'saved', 'options' => ['class' => 'alert-info']]) ?>
    <script>if (window.gridControl) window.gridControl.shouldRefresh = true</script>
<?php endif; ?>

<?php $form = ActiveForm::begin([
    'id' => 'model-form',
    'action' => ['term/update'],
    'options' => ['data-pjax' => '']
]) ?>
<?= $form->field($model, 'SemesterId')->hiddenInput()->label(false) ?>
<?= $form->field($model, 'Year')->textInput() ?>
<?= $form->field($model, 'SeasonId')->dropDownList(ArrayHelper::map($seasons, 'SeasonId', 'Name')); ?>
<?= $form->field($model, 'StartDate')->widget(DatePicker::className(), ['dateFormat' => 'yyyy-MM-dd', 'options' => ['class' => 'form-control']]) ?>
<?= $form->field($model, 'EndDate')->widget(DatePicker::className(), ['dateFormat' => Yii::$app->params['dateFormat'], 'options' => ['class' => 'form-control']]) ?>
<?= $form->field($model, 'IsCurrent')->dropDownList(Yii::$app->params['booleanSelector']) ?>
<?= \yii\bootstrap\Html::submitButton('submit', ['class' => 'btn btn-success']) ?>
<?= \yii\bootstrap\Html::button('close', ['data-dismiss' => "modal", 'class' => 'btn btn-danger', 'onclick' => 'modalFormClose()']) ?>
<?php ActiveForm::end(); ?>

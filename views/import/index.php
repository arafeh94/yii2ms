<?php
/**
 * Created by PhpStorm.
 * User: Arafeh
 * Date: 6/5/2018
 * Time: 5:46 PM
 */

/** @var \app\models\forms\DataImportForm $model */

use kartik\form\ActiveForm;
use yii\bootstrap\Html;

?>

<h1>hello</h1>

<?php $form = ActiveForm::begin() ?>
<?= $form->field($model, 'dataFile')->fileInput() ?>
<?= Html::submitButton() ?>
<?php ActiveForm::end(); ?>

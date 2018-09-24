<?php
/**
 * Created by PhpStorm.
 * User: Arafeh
 * Date: 6/5/2018
 * Time: 5:46 PM
 */

/** @var \app\models\forms\DataImportForm $model */

/** @var \app\components\DataImporter $importer */

/** @var bool $completed */

use kartik\form\ActiveForm;
use yii\bootstrap\Alert;
use yii\bootstrap\Html;
use yii\helpers\Url;

?>
<div class="card" style="padding: 8px;width: 50%;margin: auto">

    <?php if ($importer->isImporting()) : ?>
        <?php $progress = round($importer->getProgress() * 100, 0) ?>
        <?= Alert::widget([
            'closeButton' => false,
            'body' => "<b>Import in progress</b>",
            'options' => ['class' => 'alert-info']
        ]) ?>
        <div class="progress">
            <div id="progressbar" class="progress-bar" role="progressbar" aria-valuenow="<?= $progress ?>"
                 aria-valuemin="0"
                 aria-valuemax="100"
                 style="width:<?= $progress ?>%">
                <?= $progress ?>%
            </div>
        </div>
    <?php else : ?>
        <?php if ($completed) : ?>
            <?= Alert::widget([
                'closeButton' => false,
                'body' => "<b>Import Completed</b>",
                'options' => ['class' => 'alert-success']
            ]) ?>
        <?php endif; ?>

        <?php if ($importer->getErrors()) : ?>
            <?= Alert::widget([
                'closeButton' => false,
                'body' => "<b>Errors occurred while importing last file</b><br>" . implode('<br>', $importer->getErrors()),
                'options' => ['class' => 'alert-danger'],
            ]) ?>
        <?php endif; ?>
        <?php $form = ActiveForm::begin() ?>
        <?= $form->field($model, 'dataFile')->fileInput(['class' => 'inputfile']) ?>
        <?= Html::submitButton('Submit File', ['class' => 'btn btn-success']) ?>
        <?php ActiveForm::end(); ?>
    <?php endif; ?>
</div>


<?php if ($importer->isImporting()): ?>
    <script>
        window.addEventListener('load', function (ev) {
            INTERVALID = setInterval(refresher, 500);
        });
    </script>
<?php endif; ?>

<script>
    function refresher() {
        $.ajax({
            url: '<?=Url::to(['import/progress'])?>',
            dataType: 'json',
            success: function (data) {
                if (data.status === 'importing') {
                    setProgress(data.progress);
                }
                if (data.status === 'completed') {
                    clearInterval(INTERVALID);
                    window.location = '<?=Url::to(['import/index', 'completed' => true])?>';
                }
                if (data.status === 'error') {
                    clearInterval(INTERVALID);
                    window.location = '<?=Url::to(['import/index'])?>';
                }
            }
        });
    }

    function setProgress(value) {
        value = Math.round(value * 100);
        var progressBar = $('#progressbar');
        progressBar.css('width', value + '%');
        progressBar.text(value + '%');
    }
</script>
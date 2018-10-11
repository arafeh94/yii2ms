<?php
/**
 * Created by PhpStorm.
 * User: Arafeh
 * Date: 6/5/2018
 * Time: 5:46 PM
 */

/** @var \app\models\forms\DataImportForm $model */

/** @var DataImporter $importer */

/** @var bool $completed */

use app\components\DataImporter;
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
        <?php if ($importer->getErrors()) : ?>
            <?= Alert::widget([
                'closeButton' => false,
                'body' => "<b>Errors occurred while importing last file</b><br>" . implode('<br>', $importer->getErrors()),
                'options' => ['class' => 'alert-danger'],
            ]) ?>
        <?php endif; ?>

        <div style="margin: 8px 0">
            <div style="text-align: center">
                <?php foreach (DataImporter::$TEMPLATES as $key => $template): ?>
                    <?php if (!$template['enabled']) continue; ?>
                    <button class="btn btn-success" id="btn-<?= $key ?>" onclick="changeTemplate('<?= $key ?>')">
                        <?= $template['name'] ?>
                    </button>
                <?php endforeach; ?>
            </div>
            <div id="template-columns" style="margin-top: 4px;">
            </div>
        </div>

        <?php $form = ActiveForm::begin() ?>
        <?= $form->field($model, 'dataFile')->fileInput(['class' => 'inputfile'])->label(false) ?>
        <?= $form->field($model, 'template')->hiddenInput(['id' => 'template-input',])->label(false) ?>
        <div class="button-container">
            <?= Html::submitButton('Import', ['class' => 'btn btn-success']) ?>
        </div>
        <?php ActiveForm::end(); ?>
    <?php endif; ?>
</div>

<?php if ($importer->isImporting()): ?>
    <script>
        window.addEventListener('load', function (ev) {
            window.INTERVALID = setInterval(refresher, 500);
        });
    </script>
<?php endif; ?>

<script>
    var templates = <?=json_encode(\app\components\DataImporter::$TEMPLATES)?>;

    function refresher() {
        $.ajax({
            url: '<?=Url::to(['import/progress'])?>',
            dataType: 'json',
            success: function (data) {
                if (data.status === 'importing') {
                    setProgress(data.progress);
                }
                if (data.status === 'completed') {
                    clearInterval(window.INTERVALID);
                    window.location = '<?=Url::to(['import/completed'])?>';
                }
                if (data.status === 'error') {
                    clearInterval(window.INTERVALID);
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

    function changeTemplate(tp) {
        var columns = templates[tp]['columns'];
        var content = columns.join(' - ');
        content = 'Required Columns : ' + content;
        $('#template-columns').text(content);
        $("[id*='btn-tp']").removeClass('btn-danger').addClass('btn-success');
        $("#btn-" + tp).removeClass('btn-success').addClass('btn-danger');
        $('#template-input').val(tp);
    }

    window.addEventListener('load', function () {
        changeTemplate('tp1');
    });
</script>
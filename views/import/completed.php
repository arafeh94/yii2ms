<?php
/**
 * Created by PhpStorm.
 * User: Arafeh
 * Date: 10/7/2018
 * Time: 8:05 AM
 */
/** @var $importer \app\components\DataImporter */
?>

<div class="card" style="padding: 8px;width: 350px;margin: auto;text-align: center">
    <h4>Import Completed</h4>
    <button class="btn btn-success" id="btnAnother">Submit Another</button>
</div>

<script>
    document.getElementById('btnAnother').onclick = function (ev) {
        location.href = '<?= \yii\helpers\Url::to(['import/index'])?>';
    }
</script>

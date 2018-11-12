<?php
/**
 * Created by PhpStorm.
 * User: Arafeh
 * Date: 12-Nov-18
 * Time: 11:36 PM
 */
use yii\helpers\Url;
/** @var $student \app\models\Student */
?>

Are you sure you want to delete <b><?= $student->name ?></b> ?

<div class="button-container" style="margin-top: 8px">
    <button class="btn btn-danger" data-dismiss="modal" onclick="gridControl.delete(null,'<?= Url::to(['student/delete', 'id' => $student->StudentId]) ?>')">Delete</button>
    <button class="btn btn-info" data-dismiss="modal">Cancel</button>
</div>

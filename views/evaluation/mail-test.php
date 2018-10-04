<?php
/**
 * Created by PhpStorm.
 * User: Arafeh
 * Date: 9/28/2018
 * Time: 3:44 AM
 */
/** @var $res String */
?>

<form style="width: 320px;margin: auto" method="post">
    <input type="hidden" name="_csrf" value="<?= Yii::$app->request->getCsrfToken() ?>"/>
    <h3 style="width: 100%;text-align: center">Send Test Email</h3>
    <div class="form-group">
        <input type="email" class="form-control" name="to" placeholder="to">
    </div>
    <div class="form-group">
        <input type="text" class="form-control" name="content" placeholder="content">
    </div>
    <div class="form-group">
        <input type="submit" class="btn-info btn" style="text-align: center;width: 100%">
    </div>
    <?php if ($res): ?>
        <div class="alert-info" style="text-align: center">
            <?= $res ?>
        </div>
    <?php endif; ?>
</form>

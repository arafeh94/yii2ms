<?php
/**
 * Created by PhpStorm.
 * User: Arafeh
 * Date: 5/16/2018
 * Time: 6:04 PM
 */

/** @var $widget ModalForm */

use app\components\ModalForm;
use yii\bootstrap\Modal;
use yii\widgets\Pjax;

?>

<?php Modal::begin(['id' => 'dialog-form', 'header' => '<h3>User</h3>']); ?>
<div class="modal-container">
    <div id="modal-container-loading" class="modal-container-loading">
        <div class="loader"></div>
    </div>
    <div id="modal-container-form" class="modal-container-form" style="display: none">
        <?php Pjax::begin(['enablePushState' => false]) ?>
        <?= $this->render($widget->formPath); ?>
        <?php Pjax::end() ?>
    </div>
</div>
<?php Modal::end(); ?>

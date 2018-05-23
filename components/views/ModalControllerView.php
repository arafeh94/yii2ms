<?php
/**
 * Created by PhpStorm.
 * User: Arafeh
 * Date: 5/16/2018
 * Time: 6:04 PM
 */

/** @var $widget ModalForm */

use app\components\ModalForm;
use yii\bootstrap\Html;
use yii\bootstrap\Modal;
use yii\widgets\Pjax;

?>

<?php Modal::begin(['id' => 'modal-controller', 'header' => "<h3>{$widget->title}</h3>", 'size' => $widget->size]); ?>
    <div class="modal-controller-out">
        <div id="modal-controller-loading" class="modal-controller-loading">
            <div class="loader"></div>
        </div>
        <div id="modal-controller-body" class="modal-controller-in" style="display: none">
        </div>
    </div>
<?php Modal::end(); ?>
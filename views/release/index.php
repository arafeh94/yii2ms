<?php

use \yii\bootstrap\Html;

/**
 * Created by PhpStorm.
 * User: Arafeh
 * Date: 9/21/2019
 * Time: 2:49 PM
 */

/* @var $this \yii\web\View */
?>


<table class="table table-condensed table-responsive table-borderless">
    <tr>
        <td>
            <?= Html::a('Draw Acceptance', ['release/acceptance'], ['class' => 'jumbotron btn btn-info btn-block']) ?>
        </td>
        <td>
            <?= Html::a('Draw Invoice', ['release/invoice'], ['class' => 'jumbotron btn btn-info btn-block']) ?>
        </td>
    </tr>
</table>

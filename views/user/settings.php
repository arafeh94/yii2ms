<?php
/**
 * Created by PhpStorm.
 * User: Arafeh
 * Date: 5/24/2018
 * Time: 12:02 AM
 */

use app\widgets\Alert;
use kartik\widgets\ActiveForm;


/** @var $user \app\models\User */
?>



<div class="login-container card">
    <h4>Hello <?= $user->FirstName . ' ' . $user->LastName ?></h4>
    <?php $form = ActiveForm::begin() ?>
    <?= $form->field($user, 'Password')->passwordInput()->label('New Password') ?>
    <?= \yii\bootstrap\Html::submitButton('Submit', ['class' => 'btn btn-success']) ?>
    <?php ActiveForm::end() ?>
</div>
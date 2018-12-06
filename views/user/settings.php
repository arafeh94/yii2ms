<?php
/**
 * Created by PhpStorm.
 * User: Arafeh
 * Date: 5/24/2018
 * Time: 12:02 AM
 */

use kartik\widgets\ActiveForm;


/** @var $user \app\models\User */
?>

<?php if (Yii::$app->request->get('request')) : ?>
    <div class="login-container card" style="width: 90%">
        <h4>updating application may take time, please refresh later, when the
            application is update the version at the
            lower left of the page will be changed</h4>
    </div>
<?php endif; ?>

<div class="login-container card" style="width: 90%">
    <h2>Hello <?= $user->FirstName . ' ' . $user->LastName ?></h2>

    <?php $form = ActiveForm::begin() ?>
    <?= $form->field($user, 'Password')->passwordInput()->label('Change Password') ?>
    <?= \yii\bootstrap\Html::submitButton('Change', ['class' => 'btn btn-success']) ?>
    <?php ActiveForm::end() ?>
</div>

<div class="login-container card" style="width: 90%">
    <h3>Updates</h3>
    <div style="text-align: center">
        <input type="submit" value="Update Application" class="btn btn-info" style="width: 100%"
               onclick="location.href='update-application'">
    </div>
</div>


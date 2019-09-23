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

    <div class="login-container card" style="width: 90%">
        <h2>Hello <?= $user->name ?></h2>

        <?php $form = ActiveForm::begin() ?>
        <?= $form->field($user, 'password')->passwordInput()->label('Change Password') ?>
        <?= \yii\bootstrap\Html::submitButton('Change', ['class' => 'btn btn-success']) ?>
        <?php ActiveForm::end() ?>
    </div>

<?php if (\app\models\User::get()->type == 1): ?>
    <div class="login-container card" style="width: 90%">
        <h3>Updates</h3>
        <h4>May take time if there are major changes.</h4>
        <div style="text-align: center">
            <input type="submit" value="Update Application" class="btn btn-info" style="width: 100%"
                   onclick="location.href='update-application'">
        </div>
    </div>
<?php endif; ?>
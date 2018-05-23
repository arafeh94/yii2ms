<?php

/* @var $this yii\web\View */
/* @var $provider \app\models\providers\MailingDataProvider */

/* @var $semester \app\models\Semester */


use app\components\GridViewBuilder;
use app\components\ModalController;
use app\components\ModalForm;
use yii\bootstrap\Modal;

echo ModalForm::widget([
    'formPath' => '@app/views/evaluation/_form',
    'formParams' => ['semester' => $semester],
    'title' => 'Mail Instructors',
]);

echo ModalController::widget([
    'title' => 'Validate',
    'size'=> Modal::SIZE_LARGE
]);


?>



<?= GridViewBuilder::render($provider, 'Mails') ?>

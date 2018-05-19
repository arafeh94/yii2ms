<?php

/* @var $this yii\web\View */
/* @var $provider \app\models\providers\MailingDataProvider */

/* @var $semester \app\models\Semester */


use app\components\ModalForm;

echo ModalForm::widget([
    'formPath' => '@app/views/mailing/_form',
    'formParams' => ['semester' => $semester],
    'title' => 'Mail Instructors',
]);

?>

<?= \app\components\GridViewBuilder::render($provider, 'Mails') ?>

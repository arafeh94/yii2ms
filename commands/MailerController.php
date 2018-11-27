<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use app\components\SQLFileExecutor;
use app\models\InstructorEvaluationEmail;
use Yii;
use yii\console\Controller;

/**
 * This command to control sql from terminal.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class MailerController extends Controller
{
    public function actionSendMails()
    {
        $allMails = InstructorEvaluationEmail::findAll(['IsSent' => '0']);
        $mailsChunk = array_chunk($allMails, 20);
        foreach ($mailsChunk as $key => $mails) {
            foreach ($mails as $mail) {
                $message = Yii::$app->mailer
                    ->compose('evaluation/html', [
                        'instructorEvaluationEmail' => $mail,
                        'instructor' => $mail->instructor
                    ])
                    ->setFrom(Yii::$app->params['adminEmail'])
                    ->setTo($mail->instructor->Email)
                    ->setSubject('Evaluation Fill Request');
                $res = $message->send();
                if ($res) {
                    $mail->IsSent = 1;
                    $mail->save();
                } else {
                    Yii::error($res);
                }
            }
            sleep(60);
        }
    }
}

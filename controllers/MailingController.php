<?php

namespace app\controllers;

use app\components\Tools;
use app\models\EvaluationEmail;
use app\models\Instructor;
use app\models\InstructorEvaluationEmail;
use app\models\providers\MailingDataProvider;
use app\models\Semester;
use Yii;
use yii\filters\AccessControl;
use yii\helpers\Json;

class MailingController extends \yii\web\Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['admin'],
                    ],
                ],
            ],
        ];
    }


}

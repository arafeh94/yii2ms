<?php

namespace app\controllers;

use app\components\Tools;
use app\models\EvaluationEmail;
use app\models\Instructor;
use app\models\InstructorEvaluationEmail;
use app\models\providers\MailingDataProvider;
use app\models\Semester;
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

    public function actionIndex()
    {
        $provider = new MailingDataProvider();
        $provider->search(\Yii::$app->request->get('MailingSearchModel', []));
        return $this->render('index', ['provider' => $provider, 'semester' => Semester::find()->withSeason()->current()]);
    }

    public function actionView($id)
    {
        if (\Yii::$app->request->isAjax) {
            return Json::encode(EvaluationEmail::find()->active()->filter()->id($id)->one());
        }
        return false;
    }

    public function actionUpdate()
    {
        if (\Yii::$app->request->isAjax) {

            $id = \Yii::$app->request->post('EvaluationEmail')['EvaluationEmailId'];
            $model = $id === "" ? new EvaluationEmail() : EvaluationEmail::find()->active()->id($id)->one();
            $isNewRecord = $model->isNewRecord;
            if ($isNewRecord) {
                $model->Date = Tools::currentDate();
                $model->CreatedByUserId = \Yii::$app->user->identity->UserId;
                $model->SemesterId = Semester::find()->current()->SemesterId;
            }
            $saved = null;

            if ($model->load(\Yii::$app->request->post()) && $model->validate()) {
                $saved = $model->save();
                if ($saved && $isNewRecord) $this->sendInstructorEmails($model);
            }
            return $this->renderPartial('_form', ['model' => $model, 'saved' => $saved, 'semester' => Semester::find()->withSeason()->current()]);
        }
        return false;
    }

    public function actionDelete($id)
    {
        if (\Yii::$app->request->isAjax) {
            $model = EvaluationEmail::findOne($id);
            $model->IsDeleted = 1;
            return $model->save();
        }
        return false;
    }

    /**
     * @param EvaluationEmail $evaluationEmail
     */
    public function sendInstructorEmails($evaluationEmail)
    {
        $instructors = Instructor::find()->active()->all();
        foreach ($instructors as $instructor) {
            $instEvalEmail = new InstructorEvaluationEmail();
            $instEvalEmail->EvaluationEmailId = $evaluationEmail->EvaluationEmailId;
            $instEvalEmail->InstructorId = $instructor->InstructorId;
            $instEvalEmail->EvaluationCode = Tools::random();
            $instEvalEmail->save();
        }
    }

}

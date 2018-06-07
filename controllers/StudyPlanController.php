<?php

namespace app\controllers;

use app\components\Queries;
use app\components\Tools;
use app\models\Major;
use app\models\providers\StudyPlanDataProvider;
use app\models\providers\StudyPlanReportDataProvider;
use app\models\Student;
use app\models\StudyPlan;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;

class StudyPlanController extends \yii\web\Controller
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

    public function actionIndex($major)
    {
        $model = new StudyPlan();
        $model->MajorId = $major;
        $provider = new StudyPlanDataProvider(['major' => $major]);
        $provider->search(\Yii::$app->request->get('StudyPlanSearchModel', []));
        return $this->render('index', ['provider' => $provider, 'model' => $model, 'major' => Major::findOne($major)]);
    }

    public function actionView($id)
    {
        if (\Yii::$app->request->isAjax) {
            return Json::encode(StudyPlan::find()->active()->filter()->id($id)->one());
        }
        return false;
    }

    public function actionUpdate($major)
    {
        if (\Yii::$app->request->isAjax) {
            $saved = null;
            $id = \Yii::$app->request->post('StudyPlan')['StudyPlanId'];
            if ($id) {
                $model = StudyPlan::find()->active()->id($id)->one();
                if ($model->load(\Yii::$app->request->post()) && $model->validate()) {
                    $saved = $model->save();
                }
            } else {
                $post = \Yii::$app->request->post();
                $letters = ArrayHelper::getValue($post, 'StudyPlan.CourseLetter', '');
                $model = null;
                $transaction = \Yii::$app->db->beginTransaction();
                foreach (explode(',', $letters) as $letter) {
                    $model = new StudyPlan();
                    $model->MajorId = $major;
                    $model->CourseLetter = trim($letter);
                    $model->Year = ArrayHelper::getValue($post, 'StudyPlan.Year', null);
                    $model->Season = ArrayHelper::getValue($post, 'StudyPlan.Season', null);
                    if ($model->validate() && $model->save()) {
                        $saved = true;
                    } else {
                        $saved = false;
                        break;
                    }
                }
                $saved ? $transaction->commit() : $transaction->rollBack();
            }
            return $this->renderPartial('_form', ['model' => $model, 'majors' => Major::find()->active()->all(), 'saved' => $saved]);
        }
        return false;
    }

    public function actionDelete($id)
    {
        if (\Yii::$app->request->isAjax) {
            $model = StudyPlan::findOne($id);
            $model->IsDeleted = 1;
            return $model->save();
        }
        return false;
    }

    public function actionReport($student)
    {
        $student = Student::findOne($student);
        $provider = new StudyPlanReportDataProvider(['student' => $student]);
        return $this->render('report', [
            'student' => $student,
            'provider' => $provider
        ]);
    }


}

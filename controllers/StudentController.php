<?php

namespace app\controllers;

use app\models\Cycle;
use app\models\Major;
use app\models\providers\StudentDataProvider;
use app\models\search\StudentSearchModel;
use app\models\Student;
use yii\filters\AccessControl;
use yii\helpers\Json;

class StudentController extends \yii\web\Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $provider = new StudentDataProvider();
        $provider->search(\Yii::$app->request->get('StudentSearchModel', []));
        return $this->render('index', ['provider' => $provider]);
    }

    public function actionView($id)
    {
        if (\Yii::$app->request->isAjax) {
            return Json::encode(Student::find()->active()->filter()->id($id)->one());
        }
        return false;
    }

    public function actionUpdate()
    {
        if (\Yii::$app->request->isAjax) {
            $id = \Yii::$app->request->post('Student')['StudentId'];
            $model = $id === "" ? new Student() : Student::find()->active()->id($id)->one();
            if ($model->isNewRecord) $model->CreatedByUserId = \Yii::$app->user->identity->UserId;
            $saved = null;
            if ($model->load(\Yii::$app->request->post()) && $model->validate()) {
                $saved = $model->save();
            }
            return $this->renderPartial('_form', ['model' => $model,
                'cycles' => Cycle::find()->active()->all(),
                'majors' => Major::find()->active()->all(),
                'saved' => $saved
            ]);
        }
        return false;
    }

    public function actionDelete($id)
    {
        if (\Yii::$app->request->isAjax) {
            $model = Student::findOne($id);
            $model->IsDeleted = 1;
            return $model->save();
        }
        return false;
    }

}

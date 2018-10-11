<?php
/**
 * Created by PhpStorm.
 * User: Arafeh
 * Date: 5/16/2018
 * Time: 3:34 AM
 */

namespace app\models\forms;

use app\models\Course;
use app\models\OfferedCourse;
use app\models\StudentCourseEnrollment;
use app\models\User;
use Yii;
use yii\base\Model;

class EnrollmentForm extends Model
{
    public $OfferedCourseId;
    public $StudentSemesterEnrollmentId;
    public $Year;
    public $Season;

    public function rules()
    {
        return [
            [['OfferedCourseId', 'Year', 'Season', 'StudentSemesterEnrollmentId'], 'required'],
            [['OfferedCourseId'], 'exist', 'skipOnError' => true, 'targetClass' => OfferedCourse::className(), 'targetAttribute' => ['OfferedCourseId' => 'OfferedCourseId']],
            [['OfferedCourseId'], 'unique', 'targetClass' => StudentCourseEnrollment::className(), 'targetAttribute' => ['OfferedCourseId', 'StudentSemesterEnrollmentId'], 'filter' => ['IsDeleted' => 0, 'IsDropped' => 0], 'message' => Yii::t('app', 'Already Enrolled')],
        ];
    }

    public function attributeLabels()
    {
        return [
            'OfferedCourseId' => Yii::t('app', 'Offered Course'),
            'StudentSemesterEnrollmentId' => Yii::t('app', 'Student Semester Enrollment'),
            'Year' => Yii::t('app', 'Year'),
            'Season' => Yii::t('app', 'Season'),
        ];
    }

}
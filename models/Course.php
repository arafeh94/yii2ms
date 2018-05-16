<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "course".
 *
 * @property int $CourseId
 * @property int $MajorId
 * @property string $Name
 * @property string $Number
 * @property int $Credits
 * @property int $CreatedByUserId
 * @property string $DateAdded
 * @property bool $IsDeleted
 *
 * @property Major $major
 * @property StudentCourseEnrollment[] $studentCourseEnrollments
 */
class Course extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'course';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['MajorId', 'Name', 'Number', 'Credits', 'CreatedByUserId'], 'required'],
            [['MajorId', 'Credits', 'CreatedByUserId'], 'integer'],
            [['DateAdded'], 'safe'],
            [['IsDeleted'], 'boolean'],
            [['Name'], 'string', 'max' => 255],
            [['Number'], 'string', 'max' => 6],
            [['MajorId'], 'exist', 'skipOnError' => true, 'targetClass' => Major::className(), 'targetAttribute' => ['MajorId' => 'MajorId']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'CourseId' => Yii::t('app', 'Course ID'),
            'MajorId' => Yii::t('app', 'Major ID'),
            'Name' => Yii::t('app', 'Name'),
            'Number' => Yii::t('app', 'Number'),
            'Credits' => Yii::t('app', 'Credits'),
            'CreatedByUserId' => Yii::t('app', 'Created By User ID'),
            'DateAdded' => Yii::t('app', 'Date Added'),
            'IsDeleted' => Yii::t('app', 'Is Deleted'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMajor()
    {
        return $this->hasOne(Major::className(), ['MajorId' => 'MajorId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStudentCourseEnrollments()
    {
        return $this->hasMany(StudentCourseEnrollment::className(), ['OfferedCourseId' => 'OfferedCourseId']);
    }

    /**
     * @inheritdoc
     * @return CourseQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CourseQuery(get_called_class());
    }
}

<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[StudentCourseEnrollment]].
 *
 * @see StudentCourseEnrollment
 */
class StudentCourseEnrollmentQuery extends \yii\db\ActiveQuery
{
    public function active()
    {
        return $this->andWhere('[[IsDeleted]]=0');
    }

    /**
     * @inheritdoc
     * @return StudentCourseEnrollment[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return StudentCourseEnrollment|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}

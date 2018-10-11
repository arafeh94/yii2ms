<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[OfferedCourse]].
 *
 * @see OfferedCourse
 */
class OfferedCourseQuery extends \yii\db\ActiveQuery
{
    public function active()
    {
        return $this->andWhere('[[offeredcourse.IsDeleted]]=0');
    }


    public function id($id)
    {
        return $this->andWhere(['OfferedCourseId' => $id]);
    }

    public function filter()
    {
        return $this->select(['OfferedCourseId', 'CampusId', 'DateAdded', 'SemesterId', 'InstructorId', 'CourseId', 'CRN', 'Section']);
    }

    public function semester($current = true)
    {
        $semesterId = $current === true ? Semester::find()->current()->SemesterId : $current;
        return $this->where(['offeredcourse.SemesterId' => $semesterId]);
    }


    /**
     * @inheritdoc
     * @return OfferedCourse[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return OfferedCourse|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}

<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Instructor]].
 *
 * @see Instructor
 */
class InstructorQuery extends \yii\db\ActiveQuery
{
    public function active()
    {
        return $this->andWhere('[[instructor.IsDeleted]]=0');
    }


    public function id($id)
    {
        return $this->andWhere(['InstructorId' => $id]);
    }

    public function filter()
    {
        return $this->select(['InstructorId', 'DateAdded', 'UniversityId', 'FirstName', 'LastName','Title','PhoneExtension','Email']);
    }


    /**
     * @inheritdoc
     * @return Instructor[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Instructor|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}

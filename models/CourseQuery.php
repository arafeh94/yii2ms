<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Course]].
 *
 * @see Course
 */
class CourseQuery extends \yii\db\ActiveQuery
{
    public function active()
    {
        return $this->andWhere('[[course.IsDeleted]]=0');
    }

    public function id($id)
    {
        return $this->andWhere(['course.CourseId' => $id]);
    }

    public function filter()
    {
        return $this->select(['CourseId', 'MajorId', 'Name', 'Letter', 'Credits', 'DateAdded']);
    }

    /**
     * @inheritdoc
     * @return Course[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Course|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}

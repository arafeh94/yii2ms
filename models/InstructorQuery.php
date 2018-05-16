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
        return $this->andWhere('[[IsDeleted]]=0');
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

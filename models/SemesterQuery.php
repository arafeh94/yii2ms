<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Semester]].
 *
 * @see Semester
 */
class SemesterQuery extends \yii\db\ActiveQuery
{
    public function active()
    {
        return $this->andWhere('[[IsDeleted]]=0');
    }

    /**
     * @inheritdoc
     * @return Semester[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Semester|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}

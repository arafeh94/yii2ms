<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[School]].
 *
 * @see School
 */
class SchoolQuery extends \yii\db\ActiveQuery
{
    public function active()
    {
        return $this->andWhere('[[IsDeleted]]=0');
    }

    public function id($id)
    {
        return $this->andWhere(['SchoolId' => $id]);
    }

    public function filter()
    {
        return $this->select(['SchoolId', 'Name', 'DateAdded']);
    }

    /**
     * @inheritdoc
     * @return School[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return School|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}

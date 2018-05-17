<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Department]].
 *
 * @see Department
 */
class DepartmentQuery extends \yii\db\ActiveQuery
{
    public function active()
    {
        return $this->andWhere('[[department.IsDeleted]]=0');
    }

    public function id($id)
    {
        return $this->andWhere(['DepartmentId' => $id]);
    }

    public function filter()
    {
        return $this->select(['DepartmentId', 'Name', 'DateAdded', 'SchoolId']);
    }

    /**
     * @inheritdoc
     * @return Department[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Department|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}

<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Cycle]].
 *
 * @see Cycle
 */
class CycleQuery extends \yii\db\ActiveQuery
{
    public function active()
    {
        return $this->andWhere('[[cycle.IsDeleted]]=0');
    }

    public function id($id)
    {
        return $this->andWhere(['CycleId' => $id]);
    }

    public function filter()
    {
        return $this->select(['CycleId', 'Name', 'DateAdded']);
    }

    /**
     * @inheritdoc
     * @return Cycle[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Cycle|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    public function getAllNotDeleted()
    {
        return Cycle::find()->where(['IsDeleted' => 0])->all();
    }

}

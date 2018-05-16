<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[StudentPlan]].
 *
 * @see StudentPlan
 */
class StudentPlanQuery extends \yii\db\ActiveQuery
{
    public function active()
    {
        return $this->andWhere('[[IsDeleted]]=0');
    }

    /**
     * @inheritdoc
     * @return StudentPlan[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return StudentPlan|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}

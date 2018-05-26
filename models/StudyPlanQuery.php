<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[StudentPlanRow]].
 *
 * @see StudyPlan
 */
class StudyPlanQuery extends \yii\db\ActiveQuery
{
    public function active()
    {
        return $this->andWhere('[[IsDeleted]]=0');
    }

    /**
     * @inheritdoc
     * @return StudyPlan[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return StudyPlan|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}

<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[StudyPlan]].
 *
 * @see StudyPlan
 */
class StudyPlanQuery extends \yii\db\ActiveQuery
{
    public function active()
    {
        return $this->andWhere('[[studyplan.IsDeleted]]=0');
    }

    public function filter()
    {
        return $this->select(['StudyPlanId', 'MajorId', 'CourseLetter', 'Year', 'Season']);
    }

    public function major($id)
    {
        return $this->andWhere(['studyplan.MajorId' => $id]);
    }

    public function id($id)
    {
        return $this->andWhere(['studyplan.StudyPlanId' => $id]);
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

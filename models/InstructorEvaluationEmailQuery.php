<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[InstructorEvaluationEmail]].
 *
 * @see InstructorEvaluationEmail
 */
class InstructorEvaluationEmailQuery extends \yii\db\ActiveQuery
{
    public function active()
    {
        return $this->andWhere('[[IsDeleted]]=0');
    }

    /**
     * @inheritdoc
     * @return InstructorEvaluationEmail[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return InstructorEvaluationEmail|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}

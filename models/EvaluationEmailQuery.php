<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Evaluationemail]].
 *
 * @see EvaluationEmail
 */
class EvaluationEmailQuery extends \yii\db\ActiveQuery
{
    public function active()
    {
        return $this->andWhere('[[IsDeleted]]=0');
    }

    /**
     * @inheritdoc
     * @return EvaluationEmail[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return EvaluationEmail|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}

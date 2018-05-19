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
        return $this->andWhere('[[evaluationemail.IsDeleted]]=0');
    }

    public function id($id)
    {
        return $this->andWhere(['EvaluationEmailId' => $id]);
    }

    public function filter()
    {
        return $this->select(['EvaluationEmailId', 'SemesterId', 'Date', 'Quarter', 'AvailableForInstructors', 'Description', 'DateAdded']);
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

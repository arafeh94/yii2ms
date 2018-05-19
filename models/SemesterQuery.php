<?php

namespace app\models;

use Yii;

/**
 * This is the ActiveQuery class for [[Semester]].
 *
 * @see Semester
 */
class SemesterQuery extends \yii\db\ActiveQuery
{
    public function active()
    {
        return $this->andWhere('[[semester.IsDeleted]]=0');
    }

    public function id($id)
    {
        return $this->andWhere(['semester.SemesterId' => $id]);
    }

    public function filter()
    {
        return $this->select(['SemesterId', 'SeasonId', 'StartDate', 'Number', 'EndDate', 'DateAdded', 'IsCurrent', 'Year']);
    }

    /**
     * @return Semester
     */
    public function current()
    {
        return Yii::$app->db->cache(function ($db) {
            return Semester::find()->where(['IsCurrent' => 1])->one();
        }, 0);
    }

    public function withSeason()
    {
        return $this->innerJoinWith('season');
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

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
        return $this->andWhere(['semester.IsDeleted' => 0]);
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
     * @param bool $flush
     * @return Semester
     */
    public function current($flush = false)
    {
        if ($flush) Yii::$app->cache->delete('semester');
        return Yii::$app->cache->getOrSet('semester', function () {
            return Semester::find()->active()->where(['IsCurrent' => true])->one();
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

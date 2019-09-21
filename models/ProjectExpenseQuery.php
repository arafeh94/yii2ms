<?php

namespace app\models;
use app\components\extensions\AppModelQuery;
use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[ProjectExpense]].
 *
 * @see ProjectExpense
 */
class ProjectExpenseQuery extends  AppModelQuery
{
    /**
     * @inheritdoc
     * @return ProjectExpense[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

}

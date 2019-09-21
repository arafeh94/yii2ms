<?php

namespace app\models;
use app\components\extensions\AppModelQuery;
use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[Procurement]].
 *
 * @see Procurement
 */
class ProcurementQuery extends  AppModelQuery
{


    /**
     * @inheritdoc
     * @return Procurement[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Procurement|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

}

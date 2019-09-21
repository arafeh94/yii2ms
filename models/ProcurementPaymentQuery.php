<?php

namespace app\models;
use app\components\extensions\AppModelQuery;
use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[ProcurementPayment]].
 *
 * @see ProcurementPayment
 */
class ProcurementPaymentQuery extends AppModelQuery
{

    /**
     * @inheritdoc
     * @return ProcurementPayment[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }



}

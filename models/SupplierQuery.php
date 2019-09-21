<?php

namespace app\models;

use app\components\extensions\AppModelQuery;
use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[Supplier]].
 *
 * @see Supplier
 */
class SupplierQuery extends  AppModelQuery
{


    /**
     * @inheritdoc
     * @return Supplier[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Supplier|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

}

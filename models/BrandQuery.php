<?php

namespace app\models;

use app\components\extensions\AppModelQuery;
use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[Brand]].
 *
 * @see Brand
 */
class BrandQuery extends AppModelQuery
{


    /**
     * @inheritdoc
     * @return Brand[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Brand|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

}

<?php

namespace app\models;

use app\components\extensions\AppModelQuery;

/**
 * This is the ActiveQuery class for [[Meta]].
 *
 * @see Meta
 */
class MetaQuery extends AppModelQuery
{


    /**
     * @inheritdoc
     * @return Meta[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Meta|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}

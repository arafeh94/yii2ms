<?php

namespace app\models;

use app\components\extensions\AppModelQuery;
use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[ProjectPayment]].
 *
 * @see ProjectPayment
 */
class ProjectPaymentQuery extends  AppModelQuery
{


    /**
     * @inheritdoc
     * @return ProjectPayment[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @return ActiveQuery
     */
    public function active()
    {
        return $this->where('[[project_payment.is_deleted]]=0');
    }

    /**
     * @param $id
     * @return ActiveQuery
     */
    public function id($id)
    {
        return $this->where("project_payment.id=$id");
    }

    /**
     * @return ActiveQuery
     */
    public function filter()
    {
        return $this;
    }
}

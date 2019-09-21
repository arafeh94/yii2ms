<?php
/**
 * Created by PhpStorm.
 * User: Arafeh
 * Date: 9/20/2019
 * Time: 4:09 PM
 */

namespace app\components\extensions;


use yii\db\ActiveQuery;

class AppModelQuery extends ActiveQuery
{
    /**
     * @return ActiveQuery
     */
    public function active()
    {
        return $this->andWhere('[[' . $this->getPrimaryTableName() . '.is_deleted]]=0');
    }

    /**
     * @param $id
     * @return ActiveQuery
     */
    public function id($id)
    {
        return $this->andWhere('[[' . $this->getPrimaryTableName() . '.id]]=' . $id);
    }

    /**
     * @return ActiveQuery
     */
    public function filter()
    {
        return $this;
    }
}
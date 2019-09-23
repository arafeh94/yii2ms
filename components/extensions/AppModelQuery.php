<?php
/**
 * Created by PhpStorm.
 * User: Arafeh
 * Date: 9/20/2019
 * Time: 4:09 PM
 */

namespace app\components\extensions;


use app\components\Tools;
use yii\db\ActiveQuery;

class AppModelQuery extends ActiveQuery
{
    public function active()
    {
        return $this->andWhere('[[' . $this->getPrimaryTableName() . '.is_deleted]]=0');
    }

    public function id($id)
    {
        return $this->andWhere('[[' . $this->getPrimaryTableName() . '.id]]=' . $id);
    }

    public function filter()
    {
        return $this;
    }
}
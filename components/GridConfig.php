<?php
/**
 * Created by PhpStorm.
 * User: Arafeh
 * Date: 5/16/2018
 * Time: 2:53 PM
 */

namespace app\components;

use yii\base\Model;

interface GridConfig
{
    /**
     * @return array
     */
    public function gridColumns();

    /**
     * @param $param
     */
    public function search($param);

    /**
     * @param null $params
     * @return Model
     */
    public function searchModel($params = null);
}
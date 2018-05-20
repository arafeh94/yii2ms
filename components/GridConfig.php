<?php
/**
 * Created by PhpStorm.
 * User: Arafeh
 * Date: 5/16/2018
 * Time: 2:53 PM
 */

namespace app\components;

interface GridConfig
{
    /**
     * @return []
     */
    public function gridColumns();

    public function search($param);

    public function searchModel($params = null);
}
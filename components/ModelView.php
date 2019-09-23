<?php
/**
 * Created by PhpStorm.
 * User: Arafeh
 * Date: 1/22/2018
 * Time: 9:49 PM
 */

namespace app\components;

use kartik\grid\GridView;
use yii\base\Model;
use yii\base\Widget;
use yii\data\ArrayDataProvider;
use yii\helpers\ArrayHelper;
use yii\widgets\ListView;

class ModelView extends Widget
{
    /**
     * @var $model Model
     */
    public $model;


    public function init()
    {
        parent::init();
    }

    public function run()
    {
        $model = [];
        foreach ($this->model->toArray() as $key => $value) {
            if (Tools::str_ends_with($key, 'id') || strpos($key, 'is_deleted') !== false) continue;
            $model[] = ['key' => $this->model->getAttributeLabel($key), 'val' => $value];
        }
        return GridView::widget([
            'dataProvider' => new ArrayDataProvider(['allModels' => $model]),
            'options' => ['class' => 'table'],
            'showHeader' => false,
            'layout' => "{items}",
        ]);
    }
}
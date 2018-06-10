<?php
/**
 * Created by PhpStorm.
 * User: Arafeh
 * Date: 1/22/2018
 * Time: 9:49 PM
 */

namespace app\components;


use kartik\grid\GridView;
use Yii;
use yii\bootstrap\Html;
use yii\helpers\ArrayHelper;

class GridViewBuilder
{
    /**
     * @param GridConfig $provider
     * @param $title
     * @param array $config
     * @return string
     * @throws \Exception
     */
    public static function render($provider, $title, $config = [])
    {
        return GridView::widget([
            'id' => 'gridview',
            'dataProvider' => $provider,
            'filterModel' => $provider->searchModel(),
            'columns' => $provider->gridColumns(),
            'autoXlFormat' => true,
            'hover' => true,
            'export' => [
                'fontAwesome' => true,
                'showConfirmAlert' => false,
                'target' => GridView::TARGET_BLANK
            ],
            'exportConfig' => [
                GridView::PDF => Yii::$app->params['pdf']($title),
            ],
            'toolbar' => [
                ['content' =>
                    Html::button('<i class="glyphicon glyphicon-plus"></i>', ['type' => 'button', 'title' => Yii::t('app', "Add"), 'class' => 'btn btn-success', 'onclick' => 'modalForm(this)']) . ' ' .
                    Html::button('<i class="glyphicon glyphicon-repeat"></i>', ['data-pjax' => 0, 'class' => 'btn btn-default', 'title' => Yii::t('app', 'Reset Grid'), 'onclick' => 'gridControl.reload(true)']) . ' ' .
                    ArrayHelper::getValue($config, 'content', '')
                ],
                '{export}',
                '{toggleData}',
            ],
            'pjax' => true,
            'pjaxSettings' => [
                'options' => [
                    'enablePushState' => false
                ]
            ],
            'panel' => [
                'type' => 'primary',
                'heading' => $title
            ]
        ]);
    }

}
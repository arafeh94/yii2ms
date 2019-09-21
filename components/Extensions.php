<?php
/**
 * Created by PhpStorm.
 * User: Arafeh
 * Date: 1/22/2018
 * Time: 9:49 PM
 */

namespace app\components;


use Yii;
use yii\bootstrap\Html;
use yii\web\Controller;

class Extensions extends Controller
{
    public static function select2Add($url, $title)
    {
        return [
            'append' => [
                'content' => Html::a('<i class="glyphicon glyphicon-plus"></i>', Yii::$app->urlManager->createUrl(array_merge($url, ['#' => 'add'])), [
                    'class' => 'btn btn-primary',
                    'data-pjax' => 0,
                    'title' => $title
                ]),
                'asButton' => true
            ]
        ];
    }

}
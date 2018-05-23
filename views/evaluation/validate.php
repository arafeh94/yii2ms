<?php
/**
 * Created by PhpStorm.
 * User: Arafeh
 * Date: 5/22/2018
 * Time: 11:32 PM
 */

/** @var $provider EvaluationValidateDataProvider */

use app\models\providers\EvaluationValidateDataProvider;
use kartik\grid\GridView;
use yii\bootstrap\Html;

?>
<?= GridView::widget([
    'id' => 'validate',
    'dataProvider' => $provider,
    'columns' => $provider->gridColumns(),
    'pjax' => true,
    'pjaxSettings' => [
        'options' => [
            'enablePushState' => false
        ]
    ],
]); ?>



<?php
/**
 * Created by PhpStorm.
 * User: Arafeh
 * Date: 5/22/2018
 * Time: 11:32 PM
 */

use app\models\providers\EvaluationValidateDataProvider;
use kartik\grid\GridView;
use yii\bootstrap\Html;

$provider = new EvaluationValidateDataProvider();
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



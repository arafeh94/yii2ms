<?php

/** @var \app\models\providers\EvaluationReportDataProvider $provider */

use app\components\GridViewBuilder;
use yii\helpers\Html;

?>


<?= GridViewBuilder::render($provider, 'Evaluations'); ?>


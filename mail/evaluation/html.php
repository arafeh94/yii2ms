<?php
/** @var $instructorEvaluationEmail InstructorEvaluationEmail */

/** @var $instructor \app\models\Instructor */

use app\models\InstructorEvaluationEmail;
use yii\helpers\Html;
use yii\helpers\Url;

?>

please click on the link bellow
<?= Url::to(['site/eval', 'code' => $instructorEvaluationEmail->EvaluationCode], true) ?>

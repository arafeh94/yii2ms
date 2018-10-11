<?php
/**
 * Created by PhpStorm.
 * User: Arafeh
 * Date: 10/7/2018
 * Time: 3:48 AM
 */

use yii\helpers\Url;

/** @var $offeredCourse \app\models\OfferedCourse */
/** @var $enrollments [] */
$deletedUrl = $url = Url::to(['offered-course/delete', 'id' => $offeredCourse->OfferedCourseId]);
?>


<div class="text-danger">
    <h4>
        All this students enrollments will be deleted upon deleting the offered course
    </h4>
</div>
<?= \kartik\grid\GridView::widget([
    'id' => 'enrollments',
    'dataProvider' => new \yii\data\ArrayDataProvider(['allModels' => $enrollments]),
    'columns' => ['student', 'enrolledDate', 'hasGrade']
]); ?>

<div class="button-container" style="margin-top: 8px">
    <button class="btn btn-danger" data-dismiss="modal" onclick="gridControl.delete(null,'<?= $deletedUrl ?>')">Delete</button>
    <button class="btn btn-info" data-dismiss="modal">Cancel</button>
</div>
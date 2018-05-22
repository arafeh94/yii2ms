<?php
/**
 * Created by PhpStorm.
 * User: Arafeh
 * Date: 5/17/2018
 * Time: 4:03 AM
 */

namespace app\models\search;


use yii\base\Model;

class EvaluationReportSearchModel extends Model
{
    public $StudentName;
    public $CampusName;
    public $MajorName;
    public $CourseName;
    public $InstructorName;
    public $Grade;
    public $GPA;
    public $creditTaken;
    public $mGPA;
    public $majorCredit;
    public $Comment;

    public function rules()
    {
        return [

        ];
    }
}
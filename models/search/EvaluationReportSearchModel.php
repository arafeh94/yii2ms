<?php
/**
 * Created by PhpStorm.
 * User: Arafeh
 * Date: 5/17/2018
 * Time: 4:03 AM
 */

namespace app\models\search;


use app\models\EvaluationEmail;
use yii\base\Model;

class EvaluationReportSearchModel extends EvaluationEmail
{
    public $Quarter;
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
            [['Quarter', 'StudentName', 'CampusName', 'MajorName', 'CourseName', 'InstructorName', 'Grade', 'GPA', 'creditTaken', 'mGPA', 'majorCredit', 'Comment'], 'safe']
        ];
    }
}
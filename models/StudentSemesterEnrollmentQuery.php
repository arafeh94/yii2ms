<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[StudentSemesterEnrollment]].
 *
 * @see StudentSemesterEnrollment
 */
class StudentSemesterEnrollmentQuery extends \yii\db\ActiveQuery
{
    public function active()
    {
        return $this->andWhere('[studentsemesterenrollment.[IsDeleted]]=0');
    }


    public function id($id)
    {
        return $this->andWhere(['studentsemesterenrollment.StudentSemesterEnrollmentId' => $id]);
    }

    /**
     * @inheritdoc
     * @return StudentSemesterEnrollment[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }


    public function semester($current = true)
    {
        $semesterId = $current === true ? Semester::find()->current()->SemesterId : $current;
        return $this->andWhere(['studentsemesterenrollment.SemesterId' => $semesterId]);
    }

    public function student($student)
    {
        return $this->andWhere(['StudentId' => $student]);
    }

    /**
     * @inheritdoc
     * @return StudentSemesterEnrollment|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}

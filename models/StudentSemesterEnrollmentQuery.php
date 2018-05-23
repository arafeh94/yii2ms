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
        return $this->andWhere('[[IsDeleted]]=0');
    }


    public function id($id)
    {
        return $this->andWhere(['StudentSemesterEnrollmentId' => $id]);
    }

    /**
     * @inheritdoc
     * @return StudentSemesterEnrollment[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
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

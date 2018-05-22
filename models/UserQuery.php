<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[User]].
 *
 * @see User
 */
class UserQuery extends \yii\db\ActiveQuery
{
    public function active()
    {
        return $this->andWhere('[[user.IsDeleted]]=0');
    }

    public function filter()
    {
        return $this->select(['UserId', 'FirstName', 'LastName', 'Username', 'DateAdded', 'Type', 'Email']);
    }

    public function id($id)
    {
        return $this->andWhere(['UserId' => $id]);
    }

    /**
     * @inheritdoc
     * @return User[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return User|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}

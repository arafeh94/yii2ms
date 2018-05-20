<?php

namespace app\models;

use app\components\GridConfig;
use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "user".
 *
 * @property int $UserId
 * @property string $Username
 * @property string $Password
 * @property string $Email
 * @property string $FirstName
 * @property string $LastName
 * @property int $Type
 * @property bool $IsDeleted
 * @property int $CreatedByUserId
 * @property string $DateAdded
 */
class User extends ActiveRecord implements IdentityInterface
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * todo add minimum
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Username', 'Password', 'Email', 'FirstName', 'LastName', 'Type', 'CreatedByUserId'], 'required'],
            [['Type', 'CreatedByUserId'], 'integer'],
            [['IsDeleted'], 'boolean'],
            [['DateAdded'], 'safe'],
            [['Username'], 'unique', 'targetAttribute' => ['Username']],
            [['Username', 'Password', 'Email', 'FirstName', 'LastName'], 'string', 'max' => 255],
        ];
    }


    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'UserId' => Yii::t('app', 'User ID'),
            'Username' => Yii::t('app', 'Username'),
            'Password' => Yii::t('app', 'Password'),
            'Email' => Yii::t('app', 'Email'),
            'FirstName' => Yii::t('app', 'First Name'),
            'LastName' => Yii::t('app', 'Last Name'),
            'Type' => Yii::t('app', 'Type'),
            'IsDeleted' => Yii::t('app', 'Is Deleted'),
            'CreatedByUserId' => Yii::t('app', 'Created By User ID'),
            'DateAdded' => Yii::t('app', 'Date Added'),
        ];
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return self::findOne(['UserId' => $id]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return null;
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return User::findOne(['Username' => $username]);
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->UserId;
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return false;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return false;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return $this->Password === $password;
    }

    /**
     * @inheritdoc
     * @return UserQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new UserQuery(get_called_class());
    }


}

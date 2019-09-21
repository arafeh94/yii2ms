<?php

namespace app\models;

use app\components\GridConfig;
use phpDocumentor\Reflection\Types\Object_;
use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $username
 * @property string $password
 * @property string $name
 * @property int $type
 * @property bool $is_deleted
 * @property string $date_created
 * @property string $date_updated
 */
class User extends ActiveRecord implements IdentityInterface
{
    public static $ADMIN = 1;
    public static $USER = 2;

    /**
     * @return IdentityInterface|User
     */
    public static function get()
    {
        return Yii::$app->user->identity;
    }


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
            [['username', 'password', 'name', 'type'], 'required'],
            [['type'], 'integer'],
            [['is_deleted'], 'boolean'],
            [['date_added', 'date_updated'], 'date'],
            [['username', 'password', 'name'], 'string', 'max' => 255],
            [['username'], 'unique', 'targetAttribute' => ['username'], 'filter' => ['is_deleted' => 0]],
        ];
    }


    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return self::findOne(['id' => $id, 'is_deleted' => 0]);
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
        return User::findOne(['username' => $username, 'is_deleted' => 0]);
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->id;
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
        return $this->password === $password;
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

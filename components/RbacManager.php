<?php
/**
 * Created by PhpStorm.
 * User: Arafeh
 * Date: 5/19/2018
 * Time: 4:10 PM
 */

namespace app\components;


use app\models\User;
use kartik\grid\DataColumn;
use Yii;
use yii\bootstrap\ActiveForm;
use yii\rbac\PhpManager;
use yii\rbac\Role;

class RbacManager extends PhpManager
{
    public function init()
    {
        parent::init();
        if (!Yii::$app->user->isGuest) {
            $roleName = User::get()->Type == 2 ? 'user' : 'admin';
            if (!array_key_exists(User::get()->UserId, $this->assignments)) {
                /** @noinspection PhpUnhandledExceptionInspection */
                $this->assign(new Role(['name' => $roleName]), User::get()->UserId);
            }
        }
    }
}
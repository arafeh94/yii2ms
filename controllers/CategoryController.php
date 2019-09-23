<?php

namespace app\controllers;

use app\components\extensions\AppController;
use yii\filters\AccessControl;


class CategoryController extends AppController
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                    ],
                ],
            ],
        ];
    }

    public $model = 'Category';
}

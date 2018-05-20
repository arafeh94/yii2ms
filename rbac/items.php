<?php
/**
 * Created by PhpStorm.
 * User: Arafeh
 * Date: 5/20/2018
 * Time: 11:17 PM
 */

use yii\rbac\Item;

return [
    'admin' => [
        'type' => Item::TYPE_ROLE,
        'description' => 'admin',
    ],
    'user' => [
        'type' => Item::TYPE_ROLE,
        'description' => 'user',
    ],
];
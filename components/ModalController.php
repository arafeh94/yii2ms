<?php
/**
 * Created by PhpStorm.
 * User: Arafeh
 * Date: 1/22/2018
 * Time: 9:49 PM
 */

namespace app\components;

use yii\base\Widget;

class ModalController extends Widget
{
    public $id;
    public $title;
    public $size = null;

    public function init()
    {
        parent::init();
    }

    public function run()
    {
        return $this->render('ModalControllerView', ['widget' => $this]);
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: Arafeh
 * Date: 1/22/2018
 * Time: 9:49 PM
 */

namespace app\components;

use yii\base\Widget;

class ModalForm extends Widget
{
    public $formPath;
    public $title;
    public $formParams = [];
    public $includeFormButtons = true;

    public function init()
    {
        parent::init();
    }

    public function run()
    {
        return $this->render('ModalFormView', ['widget' => $this]);
    }
}
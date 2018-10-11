<?php
/**
 * Created by PhpStorm.
 * User: Arafeh
 * Date: 1/22/2018
 * Time: 9:49 PM
 */

namespace app\components;

use yii\base\Widget;

/**
 * Class ModalController
 * usage using javascript
 * modalController.show(url)
 * @package app\components
 */
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
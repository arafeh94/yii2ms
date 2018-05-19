<?php
/**
 * Created by PhpStorm.
 * User: Arafeh
 * Date: 5/19/2018
 * Time: 4:10 PM
 */

namespace app\components;


use yii\bootstrap\ActiveForm;
use yii\grid\DataColumn;

class FormInputColumn extends DataColumn
{
    /** @var ActiveForm $form */
    public $form;
    public $config = [];
    public $widget = null;

    public function init()
    {
        parent::init();
        $this->format = 'raw';
        $this->value = function ($model, $key, $index) {
            if (!$this->widget) {
                foreach ($this->config as $key => $value) {
                    if (is_callable($this->config[$key])) $this->config[$key] = $this->config[$key]($model);
                }
                return $this->form->field($model, "[{$index}]{$this->attribute}")->textInput($this->config)->label(false);
            } else {
                return $this->form->field($model, "[{$index}]{$this->attribute}")->widget($this->widget, $this->config)->label(false);
            }
        };
    }

}
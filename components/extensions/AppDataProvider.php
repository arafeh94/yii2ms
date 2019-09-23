<?php
/**
 * Created by PhpStorm.
 * User: Arafeh
 * Date: 5/16/2018
 * Time: 2:57 PM
 */

namespace app\components\extensions;


use app\components\Tools;
use kartik\editable\Editable;
use kartik\grid\GridView;
use yii\bootstrap\Html;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

abstract class AppDataProvider extends ActiveDataProvider
{
    public $searchModel;
    public $columns = null;
    public $expandable = false;

    public function init()
    {
        parent::init();
        $this->query();
        if (method_exists($this->query, 'active')) {
            $this->query->active();
        }
        $this->search();
    }

    /**
     * @return void
     */
    abstract function query();

    /**
     * @return array
     */
    abstract function columns();


    public function getColumns()
    {
        if ($this->columns == null) {
            $this->initColumns();

            $this->initActions();

            $this->initExpandable();

            $callback = 'app\components\extensions\AppDataProvider::autoIncludes';
            $this->columns = array_map($callback, $this->columns);

        }

        return $this->columns;
    }

    private function initColumns()
    {
        $this->columns = $this->columns();

        $this->columns = array_map(function ($column) {
            if (!is_array($column)) {
                $column = ['attribute' => $column];
            }
            if (!isset($column['vAlign'])) {
                $column['vAlign'] = 'middle';
            }
            return $column;
        }, $this->columns);

    }

    private function initActions()
    {
        if ($this->actions() != null) {
            $this->columns = array_merge($this->columns, [$this->actions()]);
        }
    }

    public function actions()
    {
        return [
            'class' => 'kartik\grid\ActionColumn',
            'template' => '{update} {delete}',
            'options' => ['style' => 'asd'],
            'buttons' => [
                'update' => function ($key, $model, $index) {
                    $url = Url::to([\Yii::$app->controller->id . "/view", 'id' => $model->id]);
                    return Html::tag('span', '', [
                        'class' => "glyphicon glyphicon-pencil pointer",
                        'onclick' => "modalForm(this,'$url')",
                    ]);
                },
                'delete' => function ($key, $model, $index) {
                    $url = Url::to([\Yii::$app->controller->id . '/delete', 'id' => $model->id]);
                    return Html::tag('span', '', [
                        'class' => "glyphicon glyphicon-trash pointer",
                        'onclick' => "gridControl.delete(this,'$url')",
                    ]);
                },
            ]
        ];
    }

    static function autoIncludes($column)
    {
        if (!isset($column['as'])) return $column;

        $include = $column['as'];
        unset($column['as']);

        if (is_array($include)) {
            foreach ($include as $inc) {
                $column = self::setupInclude($column, $inc);
            }
            return $column;
        } else {
            return self::setupInclude($column, $include);
        }
    }

    private static function setupInclude($column, $include)
    {
        switch ($include) {
            case 'date':
                return array_merge($column, AppDefaultColumn::$columns['date']);
            case 'editable':
                $config = AppDefaultColumn::$columns['editable'];
                if (isset($column['format']) && $column['format'] == 'date') {
                    $config['editableOptions']['inputType'] = Editable::INPUT_DATE;
                    $config['editableOptions']['options']['pluginOptions']['format'] = 'yyyy-m-dd';
                }
                $config['editableOptions']['formOptions'] = ['action' => [\Yii::$app->controller->id . '/' . 'edit']];
                return array_merge($column, $config);
            case 'checkbox':
                return array_merge($column, AppDefaultColumn::$columns['checkbox']);
            default:
                return $column;
        }
    }

    /**
     * ['course.Name','Letter']
     * @return array
     */
    abstract function searchFields();

    /**
     * ['Letter'=>'=']
     * @return array
     */
    public function searchRules()
    {
        return [];
    }


    private function search()
    {
        $searchModel = $this->initSearch();
        if (!$searchModel) return;
        $params = $searchModel->toArray();
        $rules = $this->searchRules();
        foreach (Tools::array_key_val($this->searchFields()) as $searchField => $tableField) {
            $rule = ArrayHelper::getValue($rules, $searchField, 'like');
            if (is_callable($rule)) {
                $search = $rule($searchField, $tableField);
            } else if ($rule === 'like') {
                $search = ['like', "lower($tableField)", strtolower(ArrayHelper::getValue($params, $searchField, ''))];
            } else {
                $search = [$rule, $tableField, ArrayHelper::getValue($params, $searchField, '')];
            }
            $this->query->andFilterWhere($search);
        }
    }

    /**
     * @return null | Search
     */
    public function initSearch()
    {
        if ($this->searchFields() == false || sizeof($this->searchFields()) == 0) {
            return null;
        }

        if ($this->searchModel === null) {
            $this->searchModel = new Search(Tools::array_keys($this->searchFields()));
            $this->searchModel->addRule(Tools::array_keys($this->searchFields()), 'safe');
        }

        $this->searchModel->load(\Yii::$app->request->get('Search', []), '');
        return $this->searchModel;

    }

    private function initExpandable()
    {
        if ($this->expandable) {
            $config = [
                'class' => '\kartik\grid\ExpandRowColumn',
                'value' => function ($model, $key, $index, $column) {
                    return GridView::ROW_COLLAPSED;
                },
                'detailUrl' => \Yii::$app->urlManager->createUrl([\Yii::$app->controller->id . '/detail']),
            ];

            $this->columns = array_merge($this->columns, [$config]);
        }
    }
}
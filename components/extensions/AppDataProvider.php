<?php
/**
 * Created by PhpStorm.
 * User: Arafeh
 * Date: 5/16/2018
 * Time: 2:57 PM
 */

namespace app\components\extensions;


use app\components\GridConfig;
use app\components\Tools;
use app\models\Course;
use app\models\Department;
use app\models\Major;
use app\models\search\CourseSearchModel;
use app\models\search\DepartmentSearchModel;
use app\models\search\MajorSearchModel;
use kartik\grid\BooleanColumn;
use kartik\grid\DataColumn;
use kartik\grid\GridView;
use phpDocumentor\Reflection\Types\Boolean;
use yii\base\DynamicModel;
use yii\bootstrap\Html;
use yii\data\ActiveDataProvider;
use yii\db\ActiveQueryInterface;
use yii\db\QueryBuilder;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

abstract class AppDataProvider extends ActiveDataProvider
{
    public $searchModel;
    public $includesActions = true;
    public $columns = null;

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

            $callback = 'app\components\extensions\AppDataProvider::autoIncludes';
            $this->columns = array_map($callback, $this->columns);
        }

        return $this->columns;
    }

    private function initColumns()
    {
        $this->columns = $this->columns();
    }

    private function initActions()
    {
        if (!$this->includesActions) return;

        $this->columns = array_merge($this->columns, [[
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update} {delete}',
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
            ]]
        );
    }

    static function autoIncludes($column)
    {
        if (!isset($column['include'])) return $column;

        $include = $column['include'];
        unset($column['include']);

        switch ($include) {
            case 'date':
                return array_merge($column, AppDefaultColumn::$columns['date']);
            default:
                return $column;
        }
    }

    /**
     * ['name'=>'course.Name','major'=>'major.Name','Letter']
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
        if ($this->searchModel === null) {
            $this->searchModel = new Search(Tools::array_keys($this->searchFields()));
            $this->searchModel->addRule(Tools::array_keys($this->searchFields()), 'safe');
        }

        $this->searchModel->load(\Yii::$app->request->get('Search', []), '');
        return $this->searchModel;

    }
}
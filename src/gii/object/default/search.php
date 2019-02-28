<?php
/**
 * This is the template for generating CRUD search class of the specified model.
 */

use yii\helpers\StringHelper;
use yii\db\Schema;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

$modelClass = StringHelper::basename($generator->modelClass);
$searchModelClass = StringHelper::basename($generator->searchModelClass);
if ($modelClass === $searchModelClass) {
    $modelAlias = $modelClass . 'Model';
}
$rules = $generator->generateSearchRules();
$labels = $generator->generateSearchLabels();
$searchAttributes = $generator->getSearchAttributes();
$searchConditions = $generator->generateSearchConditions();
$generateSqlSearchConditions = generateSqlSearchConditions($generator);

/**
 * Generates search conditions
 * @return array
 */
function generateSqlSearchConditions($generator)
{
    $columns = [];
    if (($table = $generator->getTableSchema()) === false) {
        $class = $generator->modelClass;
        /* @var $model \yii\base\Model */
        $model = new $class();
        foreach ($model->attributes() as $attribute) {
            $columns[$attribute] = 'unknown';
        }
    } else {
        foreach ($table->columns as $column) {
            $columns[$column->name] = $column->type;
        }
    }

    $likeConditions = [];
    $hashConditions = [];
    foreach ($columns as $column => $type) {
        switch ($type) {
            case Schema::TYPE_TINYINT:
            case Schema::TYPE_SMALLINT:
            case Schema::TYPE_INTEGER:
            case Schema::TYPE_BIGINT:
            case Schema::TYPE_BOOLEAN:
            case Schema::TYPE_FLOAT:
            case Schema::TYPE_DOUBLE:
            case Schema::TYPE_DECIMAL:
            case Schema::TYPE_MONEY:
            case Schema::TYPE_DATE:
            case Schema::TYPE_TIME:
            case Schema::TYPE_DATETIME:
            case Schema::TYPE_TIMESTAMP:
                $hashConditions[] = "'{$column}' => sprintf('{$column} = \"%s\"',\$this->{$column}),";
                break;
            default:
                $likeKeyword = \Yii::$app->db->driverName === 'pgsql' ? 'ilike' : 'like';
                $likeConditions[] = "'{$column}' => sprintf('{$column} {$likeKeyword} \"%s%%\"',\$this->{$column}),";
                break;
        }
    }

    return array_merge($hashConditions, $likeConditions);
}

echo "<?php\n";
?>

namespace <?= StringHelper::dirname(ltrim($generator->searchModelClass, '\\')) ?>;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\data\SqlDataProvider;
use <?= ltrim($generator->modelClass, '\\') . (isset($modelAlias) ? " as $modelAlias" : "") ?>;

/**
 * <?= $searchModelClass ?> represents the model behind the search form of `<?= $generator->modelClass ?>`.
 */
class <?= $searchModelClass ?> extends <?= isset($modelAlias) ? $modelAlias : $modelClass ?>

{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            <?= implode(",\n            ", $rules) ?>,
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = <?= isset($modelAlias) ? $modelAlias : $modelClass ?>::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,<?= (in_array('id', $searchAttributes)) ? "\n            'sort' => ['defaultOrder' => ['id' => SORT_DESC]]\n" : '' ?>
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        <?= implode("\n        ", $searchConditions) ?>

        return $dataProvider;
    }

    /**
     * Creates data provider instance with search query and sql applied
     *
     * @param array $params
     *
     * @return SqlDataProvider
     */
    public function sqlSearch($params)
    {
        $this->load($params);

        <?= '$where '."=[\n           " . implode("\n           ", $generateSqlSearchConditions) . "\n        ];\n" ?>

        $filtedParams = array_filter($this->attributes,
            function($val){return $val!='';});

        $FiltedWhere = ['1=1'];
        foreach ($filtedParams as $key => $value) {
            $FiltedWhere[] = $where[$key];
        }

        $querySql = sprintf('
            SELECT
                %s
            FROM
                %s
            WHERE
                %s
            ', '*', $this->tableName(), implode(' AND ', $FiltedWhere));

        $countSql = sprintf('
            SELECT
                %s
            FROM
                %s
            WHERE
                %s
            ', 'count(1)', $this->tableName(), implode(' AND ', $FiltedWhere));

        $sqlDataProvider = new SqlDataProvider([
            'sql' => $querySql,
            // 'params' => [':sex' => 1],
            'totalCount' => Yii::$app->db->createCommand($countSql)->queryScalar(),
            //'sort' =>false,//如果为假则删除排序
            'key' => 'id',
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC
                ],
                'attributes' => array_keys($this->attributes),
            ],
            'pagination' => [
                'pageSize' => 30,
            ],
        ]);

        return $sqlDataProvider;
    }
}

<?php
namespace myzero1\rest\components;
use yii\data\ActiveDataProvider;

/**
 * PostSearch represents the model behind the search form of `api\models\Post`.
 */
class ApiDataProvider
{
    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public static function create($modelClass, $params)
    {
        $query = $modelClass::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => false,
            'pagination' => false,
        ]);

        $paramsNew = ApiDataProvider::decodeParams($params);

        if (isset($paramsNew['sort'])) {
            $tmp = [];
            if ( strtoupper($paramsNew['sort'][1]) == 'DESC' ) {
                $order[$paramsNew['sort'][0]] = SORT_DESC;
            } else {
                $order[$paramsNew['sort'][0]] = SORT_ASC;
            }
            $query->addOrderBy($order);
        }

        if (isset($paramsNew['range'])) {
            $query->limit($paramsNew['range'][1] - $paramsNew['range'][0])->offset($paramsNew['range'][0]);
            $rangeStart = $paramsNew['range'][0];
            $rangeEnd = $paramsNew['range'][1];
        } else {
            $query->limit(20)->offset(0);
            $rangeStart = 0;
            $rangeEnd = 20;
        }

        if (isset($paramsNew['filter'])) {
            $model = new $modelClass();

            foreach ($paramsNew['filter'] as $k => $v) {
                $column = $model->getTableSchema()->getColumn($k);
                if ($column) {
                    if ( in_array($column->type, ['int', 'bigint']) ) {
                        $query->andFilterWhere(['=', $k, $v]);
                    } else {
                        $query->andFilterWhere(['like', $k, $v]);
                    }
                }
            }

            // get many
            if (isset($paramsNew['filter']['ids'])) {
                $query->andFilterWhere(['in', 'id', $paramsNew['filter']['ids']]);
            }
        }

        // set the header for api
        $contentRange = sprintf("%ss %d-%d/%d",
            \Yii::$app->controller->id,
            $rangeStart,
            $rangeEnd,
            $dataProvider->getTotalCount());
        \Yii::$app->response->headers->add('Content-Range', $contentRange);

        return $dataProvider;

    }
    // http://api.test/v1/posts?sort=["id","ASC"]&range=[0,9]&filter={"title":"i"}
    public static function decodeParams($params){
        $keys = ['sort', 'range', 'filter'];
        $paramsNew = [];
        foreach ($keys as $k => $v) {
            if (isset($params[$v])) {
                if ($tmp = json_decode($params[$v], TRUE)) {
                     $paramsNew[$v] = $tmp;
                }
            }
        }

        return $paramsNew;
    }
}

<?php

namespace myzero1\rest\controllers;
use yii\web\Response;
use yii\rest\ActiveController;
use api\models\searches\ApiDataProvider;

class ApiController extends ActiveController
{
    public $modelClass = '';

    public function behaviors() {
        $behaviors = parent::behaviors();
        $behaviors['contentNegotiator']['formats']['text/html'] = Response::FORMAT_JSON;
        return $behaviors;
    }

    public function actions()
    {
        $actions = parent::actions();
        $actions['index']['prepareDataProvider'] = [$this, 'prepareDataProvider'];
        return $actions;
    }

    public function prepareDataProvider()
    {
        return ApiDataProvider::create($this->modelClass, \Yii::$app->request->getQueryParams());
    }
}
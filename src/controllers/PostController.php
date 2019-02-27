<?php

namespace myzero1\rest\controllers;

use Yii;
use myzero1\rest\models\Post;
use yii\data\ActiveDataProvider;
use yii\rest\ActiveController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use myzero1\rest\components\ApiController;

/**
 * PostController implements the CRUD actions for Post model.
 */
class PostController extends ApiController 
{
    public $modelClass = 'backend\modules\v1\models\Post';
}

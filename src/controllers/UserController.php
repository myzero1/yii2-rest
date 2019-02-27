<?php

namespace myzero1\rest\controllers;

use Yii;
use myzero1\rest\models\User;
use yii\data\ActiveDataProvider;
use yii\rest\ActiveController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use myzero1\rest\components\ApiController;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends ApiController 
{
    public $modelClass = 'backend\modules\v1\models\User';
}

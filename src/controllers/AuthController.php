<?php

namespace myzero1\rest\controllers;

use Yii;
use myzero1\rest\models\User;
use yii\data\ActiveDataProvider;
use yii\rest\ActiveController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use myzero1\rest\components\ApiController;

use yii\filters\AccessControl;
use myzero1\rest\models\LoginForm;

/**
 * AuthController implements the CRUD actions for User model.
 */
class AuthController extends ApiController 
{

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['join', 'login'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['info'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'join' => ['post'],
                    'login' => ['post'],
                    'info' => ['get'],
                ],
            ],
        ];
    }

    /**
     * Join action.
     *
     * @return string
     */
    public function actionJoin()
    {
        var_dump('actionJoin');exit;
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin ()
    {
        $model = new LoginForm;
        $model->setAttributes(Yii::$app->request->post());
        if ($user = $model->login()) {
            return [
                'code' => 200200,
                'msg' => 'success',
                'data' => $user->api_token,
            ];
        } else {
            $errors = [];
            foreach ($model->errors as $key => $value) {
                $errors[] = implode(';', $value);
            }
            $errorMsg = implode(';', $errors);
            
            return [
                'code' => 200500,
                'msg' => $errorMsg,
                'data' => '',
            ];
        }
    }

    /**
     * Info action.
     *
     * @return string
     */
    public function actionInfo()
    {
        // $user = $this->authenticate(Yii::$app->user, Yii::$app->request, Yii::$app->response);

        // return [
        //     'code' => 200500,
        //     'msg' => '',
        //     'data' => $user,
        // ];
        var_dump('expression');exit;
    }
}
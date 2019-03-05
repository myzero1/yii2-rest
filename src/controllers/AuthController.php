<?php

namespace myzero1\rest\controllers;

use Yii;
use yii\data\ActiveDataProvider;
use yii\rest\ActiveController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use myzero1\rest\components\ApiController;

use yii\filters\AccessControl;
use myzero1\rest\models\LoginForm;
use myzero1\rest\models\User;

/**
 * AuthController implements the CRUD actions for User model.
 */
class AuthController extends ApiController 
{
    /**
     * Join action.
     *
     * @return string
     */
    public function actionJoin()
    {
        $model = new User();
        if ($model->load(Yii::$app->getRequest()->getBodyParams(), '') && $model->save()) {
            $response = Yii::$app->getResponse();
            $response->setStatusCode(201);
        } elseif (!$model->hasErrors()) {
            throw new ServerErrorHttpException('Failed to create the object for unknown reason.');
        }
        return $model;
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
            // return [
            //     'code' => 200200,
            //     'msg' => 'success',
            //     'data' => $user->api_token,
            // ];
            return $user->api_token;
        } else {
            $errors = [];
            foreach ($model->errors as $key => $value) {
                $errors[] = implode(';', $value);
            }
            $errorMsg = implode(';', $errors);
            
            // return [
            //     'code' => 200500,
            //     'msg' => $errorMsg,
            //     'data' => '',
            // ];
            return $errorMsg;
        }
    }

    /**
     * Info action.
     *
     * @return string
     */
    public function actionInfo()
    {
        $user = $this->authenticate(Yii::$app->user, Yii::$app->request, Yii::$app->response);

        // return [
        //     'code' => 200500,
        //     'msg' => '',
        //     'data' => $user,
        // ];
        return $user;
    }
}
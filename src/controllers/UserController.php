<?php

namespace myzero1\rest\controllers;
use myzero1\rest\components\ApiController;
use myzero1\rest\models\LoginForm;
use myzero1\rest\models\User;
use Yii;

class UserController extends ApiController
{
    public $modelClass = 'myzero1\rest\models\User';
     
    //注册-测试用
    public function actionReg()
    {
        $user = new User();
        $user->generateAuthKey();
        $user->setPassword('123456');
        $user->username = 'test';
        $user->save(false);
        return [
            'code' => 0
        ];
  }    

    //登录
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

    //获取用户信息
    public function actionInfo()
    {
        $user = $this->authenticate(Yii::$app->user, Yii::$app->request, Yii::$app->response);

        return [
            'code' => 200500,
            'msg' => '',
            'data' => $user,
        ];
    }
}
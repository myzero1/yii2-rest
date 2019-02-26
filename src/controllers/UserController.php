<?php

namespace myzero1\rest\controllers;
use myzero1\rest\components\ApiController;
use myzero1\rest\models\LoginForm;
use myzero1\rest\models\User;
use Yii;

class UserController extends ApiController
{

    /**
     *
     *
     *
     * @SWG\Tag(
     *   name="users",
     *   description="用户相关操作",
     *   @SWG\ExternalDocumentation(
     *     description="Find out more about our store",
     *     url="http://swagger.io"
     *   )
     * )
     *
     * @SWG\Get(path="/users",
     *     tags={"users"},
     *     summary="获取用户列表",
     *     description="获取用户列表：actionIndex GET_LIST GET /users?sort=[""id"",""ASC""]&range=[0, 2]&filter={""status"":""10""}",
     *     produces={"application/json"},
     *
     *     @SWG\Parameter(
     *        in = "query",
     *        name = "sort",
     *        description = "排序",
     *        required = false,
     *        type = "string",
     *        default = "[""id"",""ASC""]",
     *     ),
     *     @SWG\Parameter(
     *        in = "query",
     *        name = "range",
     *        description = "记录区间",
     *        required = false,
     *        type = "string",
     *        default = "[0, 2]",
     *     ),
     *     @SWG\Parameter(
     *        in = "query",
     *        name = "filter",
     *        description = "查询条件",
     *        required = false,
     *        type = "string",
     *        default = "{""status"":""10""}",
     *     ),
     *
     *     @SWG\Response(
     *         response = 200,
     *         description = " success"
     *     )
     * )
     *
     *
     *
     * @SWG\Get(path="/users/{id}",
     *     tags={"users"},
     *     summary="获取用户详情",
     *     description="获取用户详情：actionView GET_ONE GET /users/1",
     *     produces={"application/json"},
     *
     *     @SWG\Parameter(
     *        in = "path",
     *        name = "id",
     *        description = "数据记录Id",
     *        required = true,
     *        type = "integer",
     *        default = 1,
     *     ),
     *
     *     @SWG\Response(
     *         response = 200,
     *         description = " success"
     *     )
     * )
     *
     *
     *
     * @SWG\Post(path="/users",
     *     tags={"users"},
     *     summary="获取用户详情",
     *     description="获取用户详情：actionView GET_ONE GET /users/1",
     *     produces={"application/json"},
     *
     *     @SWG\Parameter(
     *        in = "body",
     *        name = "body",
     *        description = "数据记录Id",
     *        required = true,
            type = "string",
     *        @SWG\Schema(ref = "#/definitions/User")
     *     ),
     *
     *     @SWG\Response(
     *         response = 200,
     *         description = " success"
     *     )
     * )
     *
     *
     *
     *
     */

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
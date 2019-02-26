<?php
namespace myzero1\rest\components;
use yii\web\Response;
use yii\rest\ActiveController;
use yii\filters\auth\HttpBearerAuth;
use api\models\searches\ApiDataProvider;
use yii\filters\RateLimiter;
use yii\filters\Cors;

class ApiController extends ActiveController
{
    public $modelClass = '';

    public function behaviors() {
        $behaviors = parent::behaviors();
        $behaviors['contentNegotiator']['formats']['text/html'] = Response::FORMAT_JSON;

        unset($behaviors['authenticator']);
        /*
        取消默认authenticator认证，以确保 cors 被首先处理。然后，我们在实施自己的认证程序之前，强制 cors 允许凭据。
        */

        //设置跨域
        // $behaviors['corsFilter'] = [
        //     'class' => Cors::className(),
        //     'cors' => [
        //         'Origin' => ['*'],
        //         'Access-Control-Request-Method' => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'HEAD', 'OPTIONS'],
        //         'Access-Control-Request-Headers' => ['*'],
        //         'Access-Control-Allow-Credentials' => true,
        //     ],
        // ];

        $behaviors['authenticator'] = [
            'class' => HttpBearerAuth::className(),
            'optional' => [
                'login',  //认证排除登录接口
                'reg' //认证排除测试注册用户
            ],
            'except'=> ['options'], //认证排除OPTIONS请求
        ];

        # rate limit部分，速度的设置是在
        #   app\models\User::getRateLimit($request, $action)
        /*  官方文档：
            当速率限制被激活，默认情况下每个响应将包含以下HTTP头发送 目前的速率限制信息：
            X-Rate-Limit-Limit: 同一个时间段所允许的请求的最大数目;
            X-Rate-Limit-Remaining: 在当前时间段内剩余的请求的数量;
            X-Rate-Limit-Reset: 为了得到最大请求数所等待的秒数。
            你可以禁用这些头信息通过配置 yii\filters\RateLimiter::enableRateLimitHeaders 为false, 就像在上面的代码示例所示。
        */
        $behaviors['rateLimiter'] = [
            'class' => RateLimiter::className(),
            'enableRateLimitHeaders' => true,
        ];

        return $behaviors;
    }

    public function actions()
    {
        $actions = parent::actions();
        $actions['index']['prepareDataProvider'] = [$this, 'prepareDataProvider'];

        //设置固定options控制器
        $actions['options'] = [
            'class' => 'yii\rest\OptionsAction',
            // optional:
            'collectionOptions' => ['GET', 'POST', 'HEAD', 'OPTIONS'],
            'resourceOptions' => ['GET', 'PUT', 'PATCH', 'DELETE', 'HEAD', 'OPTIONS'],
        ];

        return $actions;
    }

    public function prepareDataProvider()
    {
        return ApiDataProvider::create($this->modelClass, \Yii::$app->request->getQueryParams());
    }
}
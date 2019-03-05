<?php
/**
 * This is the swagger's template of model.
 */

use yii\helpers\StringHelper;

$prefix = StringHelper::dirname(dirname(ltrim($generator->controllerClass, '\\')));

echo "<?php\n";
?>

namespace <?= sprintf('%s\%s', $prefix, 'components') ?>;

use yii\web\Response;
use yii\rest\ActiveController;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\RateLimiter;
use yii\filters\Cors;

class BasicController extends ActiveController
{
    public $modelClass = '';

    public function init(){
        \Yii::$app->request->parsers = [
            'application/json' => '\yii\web\JsonParser',
            'text/json'        => '\yii\web\JsonParser',
        ];
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        \Yii::$app->response->on(\yii\web\Response::EVENT_BEFORE_SEND, function($event){
            $response = $event->sender;
            $dataOrion = $response->data;
            $data = [];
            
            if (isset($dataOrion['code'])) {
                $data['code'] = $dataOrion['code'];
            } else {
                $data['code'] = $response->getStatusCode();
            }
            if (isset($dataOrion['msg'])) {
                $data['msg'] = $dataOrion['msg'];
            } else {
                $data['msg'] = $response->statusText;
            }
            if (isset($dataOrion['data'])) {
                $data['data'] = $dataOrion['data'];
            } else {
                $data['data'] = $response->data;
            }

            $response->data = $data;
        });
    }

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
                'join', //认证排除注册用户
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
        // $behaviors['rateLimiter'] = [
        //     'class' => RateLimiter::className(),
        //     'enableRateLimitHeaders' => true,
        // ];

        return $behaviors;
    }

    public function actions()
    {
        $actions = parent::actions();

        //设置固定options控制器
        $actions['options'] = [
            'class' => 'yii\rest\OptionsAction',
            // optional:
            'collectionOptions' => ['GET', 'POST', 'HEAD', 'OPTIONS'],
            'resourceOptions' => ['GET', 'PUT', 'PATCH', 'DELETE', 'HEAD', 'OPTIONS'],
        ];

        return $actions;
    }
}
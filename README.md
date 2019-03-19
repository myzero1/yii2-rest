yii2-rest
========================

Rest api with wagger in yii2.

Show time
------------

![](https://github.com/myzero1/show-time/blob/master/yii2-rest/screenshot/201.png)
![](https://github.com/myzero1/show-time/blob/master/yii2-rest/screenshot/202.png)
![](https://github.com/myzero1/show-time/blob/master/yii2-rest/screenshot/203.png)
![](https://github.com/myzero1/show-time/blob/master/yii2-rest/screenshot/204.png)
![](https://github.com/myzero1/show-time/blob/master/yii2-rest/screenshot/205.png)
![](https://github.com/myzero1/show-time/blob/master/yii2-rest/screenshot/206.png)
![](https://github.com/myzero1/show-time/blob/master/yii2-rest/screenshot/207.png)

Installation
------------

The preferred way to install this module is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require myzero1/yii2-rest：1.*
```

or add

```
"myzero1/yii2-rest": "~1"
```

to the require section of your `composer.json` file.



Setting
-----

Once the extension is installed, simply modify your application configuration(main.php) as follows:

```php
return [
    ......
    'bootstrap' => [
        ......
        'log',
        [
            'class' => 'backend\modules\v1\Bootstrap',
            'params' => [
                'apiTokenExpire' => 1*24*3600,      
                'rateLimit' => [2000,3], // 2times/3s 
                'swaggerConfig' => [
                    'schemes' => '{http}',
                    'host' => 'yii2rest3.test',
                    'basePath' => '/v1',
                    'info' => [
                        'title' => '接口文档',
                        'version' => '1.0.0',
                        'description' => '这是关于: __react-admin__（https://github.com/marmelab/react-admin/tree/master/packages/ra-data-simple-rest）的rest api',
                            'contact' => [
                                'name' => 'myzero1',
                                'email' => 'myzero1@sina.com',
                            ],
                    ]
                ],
            ],
        ],
        ......
    ],
    ......
    'components' => [
        ......
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [],
        ],
        ......
    ],
    ......
];
```

Setting the gii in main-local.php as follows:

```php
    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        'allowedIPs' => ['*'],
        'generators' => [
            'module-rest-swagger' => [
                'class' => 'myzero1\rest\gii\auth\Generator',
                'templates' => [
                    'rest' => 'myzero1\rest\gii\auth\default'
                ]
            ],
            'obj-rest-swagger' => [
                'class' => 'myzero1\rest\gii\object\Generator',
                'templates' => [
                    'rest' => 'myzero1\rest\gii\object\default'
                ]
            ],
        ]
    ];
```


Setting the actions in siteController.php as follows:

```php
use yii\filters\AccessControl;
use yii\helpers\Url;
......
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
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index', 'doc', 'api'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }
......
    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
            'doc' => [
                'class' => 'myzero1\rest\swaggertools\SwaggerAction',
                'restUrl' => url::to(['/site/api'], true),
            ],
            'api' => [
                'class' => 'myzero1\rest\swaggertools\SwaggerApiAction',
                'scanDir' => [
                    Yii::getAlias('@vendor/myzero1/yii2-rest/src/swaggertools/config'),
                    Yii::getAlias('@backend/modules/v1/swagger'),
                ],
                // 'api_key' => 'test'
            ],
        ];
    }
```

Usage
-----

You can then access swagger page.

```
http://yii2rest2.test/site/doc
```


You can then access gii page to watch the rest generator.

```
http://yii2rest2.test/gii/default/view?id=api-rest
```


swagger json to html2
-----

We can get the api document of html

```
1、http://wh-shenji.test/site/api通過這個地址獲取wagger的json文件
2、https://editor.swagger.io/把json文件內複製到這裡
3、把schemes: '{http}'改為 
    schemes: 
	- http
4、點擊Generate Client》html2把json轉換為html
5、把“<style type="text/css">.sidenav > li.nav-header > a:hover{color:#094867;}</style>”添加到html的最后面
```



Ajax 请求api
-----
eg

```

var url = "http://172.16.62.242:8735/v1/auth/info";
var type = "get"//POST、PUT、DELETE
var authorization = "Bearer Y057DL29xjEwXHAGOVXW9PfGF-xsSIoW_1552974468";
var data = {};

$.ajax({
    url: url,
    type: type,//POST、PUT、DELETE
	//data:JSON.stringify(myData),//你要传的参数
	data: data,//你要传的参数
	processData:false,//是否对参数进行序列化，会把{name:'huang',sex:1}序列化name='huang'&sex=1,默认为true。
	contentType:"application/json",//这里是Header中自带的contentType
    beforeSend: function (xhr) { 
        xhr.setRequestHeader("Authorization", authorization);//你要传的参数
    },
    success: function (data) {
        console.log(data);
    },
    error: function (xhr, textStatus, errorThrow) {
        alert("error:"+xhr.readyState);
    }
});
```

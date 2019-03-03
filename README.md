yii2-rest
========================

Rest api with wagger in yii2.

Show time
------------

![](https://github.com/myzero1/show-time/blob/master/yii2-rest/screenshot1/101.png)
![](https://github.com/myzero1/show-time/blob/master/yii2-rest/screenshot1/102.png)
![](https://github.com/myzero1/show-time/blob/master/yii2-rest/screenshot1/103.png)
![](https://github.com/myzero1/show-time/blob/master/yii2-rest/screenshot1/104.png)
![](https://github.com/myzero1/show-time/blob/master/yii2-rest/screenshot1/105.png)

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
    'components' => [
        'request' => [
            'class' => '\yii\web\Request',
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
                'text/json' => 'yii\web\JsonParser',
            ]
        ],
        'response' => [
            'class' => 'yii\web\Response',
            'format' => yii\web\Response::FORMAT_JSON,
            'charset' => 'UTF-8',
            'on beforeSend' => function ($event) {
                    //restful api
                    $response = $event->sender;

                    if (isset($response->data['code'])) {
                        $code = $response->data['code'];
                    } else {
                        $code = $response->getStatusCode();
                    }

                    if (isset($response->data['msg']) && $response->data['msg']) {
                        $msg = $response->data['msg'];
                    } else {
                        $msg = $response->statusText;
                    }

                    if (isset($response->data['data'])) {
                        $dataOld = $response->data['data'];
                    } else {
                        $dataOld = $response->data;
                    }

                    //设置固定返回数据参数
                    $data = [
                        'code' => $code,
                        'msg' => $msg,
                        'data' => $dataOld,
                    ];
                    $response->data = $data;
            },
        ],
        ......
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                [
                    'class' => 'yii\rest\UrlRule' ,
                    'controller' => [
                        'rest/user'
                    ]
                ],
                '<controller:\+w>/action:\+w>' => '<controller>/<action>'
            ],
        ],
        ......
    ],
    ......
    'modules' => [
        ......
        'rest' => [
            'class' => 'myzero1\rest\Module',
            'params' => [
                'swaggerConfig' => [
                    'schemes' => '{"http"}',
                    'host' => 'yii2rest2.test',
                    'basePath' => '/rest',
                    'info' => [
                        'title' => '接口文档',
                        'version' => '1.0.0',
                        'description' => '这是关于: __react-admin__（ https://github.com/marmelab/react-admin/tree/master/packages/ra-data-simple-rest ）的rest api',
                        'contact' => [
                            'name' => 'myzero1',
                            'email' => 'myzero1@sina.com',
                        ],
                    ]
                ]
            ],
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
            'api-rest' => [
                'class' => 'myzero1\rest\gii\Generator',
                'templates' => [
                    'rest' => 'myzero1\rest\gii\default'
                ]
            ]
        ]
    ];
```


Setting the actions in siteController.php as follows:

```php

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








    'bootstrap' => [
        'log',
        [
            'class' => 'backend\modules\v25\Bootstrap',
            'params' => [
                'moduleId' => 'v25',
                'swaggerConfig' => [
                    'schemes' => '{http}',
                    'host' => 'yii2rest.test',
                    'basePath' => '/v25',
                    'info' => [
                        'title' => '接口文档',
                        'version' => '1.0.0',
                        'description' => '这是关于: __react-admin__（https://github.com/marmelab/react-admin/tree/master/packages/ra-data-simple-rest）的rest api',
                        // 'contact' => 'name = "myzero1", email = "myzero1@sina.com"',
                    ]
                ],
            ],
        ]
    ],

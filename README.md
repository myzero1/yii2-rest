# yii2-rest


    'modules' => [
        'rest' => [
            'class' => 'myzero1\rest\Module',
            'swaggerConfig' => [
                'schemes' => '{"http"}',
                'host' => '"yii2rest.test"',
                'basePath' => '"/rest"',
                'info' => [
                    'title' => '接口文档1111',
                    'version' => '1.0.0',
                    'description' => '这是关于: __react-admin__（ https://github.com/marmelab/react-admin/tree/master/packages/ra-data-simple-rest ）的rest api',
                    'contact' => [
                        'name' => 'myzero1',
                        'email' => 'myzero1@sina.com',
                    ],
                ]
            ],
        ],
    ],

        'request'      => [
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
                'text/json'        => 'yii\web\JsonParser',
            ],
        ],
        
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


    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            //The document preview addesss:http://api.yourhost.com/site/doc
            'doc' => [
                'class' => 'myzero1\rest\swagger\SwaggerAction',
                'restUrl' => \yii\helpers\Url::to(['/site/api'], true),
            ],
            //The resultUrl action.
            'api' => [
                // 'class' => 'light\swagger\SwaggerApiAction',
                'class' => 'myzero1\rest\swagger\SwaggerApiAction',
                //The scan directories, you should use real path there.
                'scanDir' => [
                    Yii::getAlias('@vendor/myzero1/yii2-rest/src/swagger'),
                    Yii::getAlias('@vendor/myzero1/yii2-rest/src/controllers'),
                    Yii::getAlias('@vendor/myzero1/yii2-rest/src/models'),
                ],
                //The security key
                //'api_key' => 'test',
            ],
        ];
    }
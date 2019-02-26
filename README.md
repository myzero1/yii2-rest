# yii2-rest


    'modules' => [
        'rest' => [
            'class' => 'myzero1\rest\Module',
        ]
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
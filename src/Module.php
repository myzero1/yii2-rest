<?php

namespace myzero1\rest;

/**
 * v1 module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    // public $controllerNamespace = 'myzero1\rest\controllers';

    public $swaggerConfig = [
        'schemes' => '{"http"}',
        'host' => '"yii2rest.test"',
        'basePath' => '"/rest"',
        'info' => [
            'title' => '"接口文档"',
            'version' => '"1.0.0"',
            'contact' => 'name = "myzero1", email = "myzero1@sina.com"',
        ]
    ];

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();
        //由于RESTful遵循的是无状态可将用户session关闭
        \Yii::$app->user->enableSession = false;
        //关闭登录失败跳转
        \Yii::$app->user->loginUrl = null;
    }
}

<?php

/*
 * This file is part of the myzero1/yii2-rest.
 *
 * (c) myzero1 <myzero1@sina.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace myzero1\rest\swaggertools;

use Yii;
use yii\base\Action;
use yii\caching\Cache;
use yii\web\Response;

/**
 * The api data output action.
 *
 * ~~~
 * public function actions()
 * {
 *     return [
 *         'api' => [
 *             'class' => 'myzero1\rest\swagger\SwaggerApiAction',
 *             'scanDir' => [
 *                 Yii::getAlias('@vendor/myzero1/yii2-rest/src/swaggertools'),
 *                 Yii::getAlias('@vendor/myzero1/yii2-rest/src/swagger'),
 *                 Yii::getAlias('@vendor/myzero1/yii2-rest/src/controllers'),
 *                 Yii::getAlias('@vendor/myzero1/yii2-rest/src/models'),
 *                 ...
 *             ]
 *         ]
 *     ];
 * }
 * ~~~
 */
class SwaggerApiAction extends Action
{
    /**
     * @var string|array|\Symfony\Component\Finder\Finder The directory(s) or filename(s).
     * If you configured the directory must be full path of the directory.
     */
    public $scanDir;
    /**
     * @var string api key, if configured will perform the authentication.
     */
    public $api_key;
    /**
     * @var string Query param to get api key.
     */
    public $apiKeyParam = 'api_key';
    /**
     * @var array The options passed to `Swagger`, Please refer the `Swagger\scan` function for more information.
     */
    public $scanOptions = [];
    /**
     * @var Cache|string|null the cache object or the ID of the cache application component that is used to store
     * Cache the \Swagger\Scan
     */
    public $cache = null;
    /**
     * @var string Cache key
     * [[cache]] must not be null
     */
    public $cacheKey = 'api-swagger-cache';
    
    /**
     * @inheritdoc
     */
    public function run()
    {
        $this->initCors();
        
        Yii::$app->response->format = Response::FORMAT_JSON;
        
        $headers = Yii::$app->getRequest()->getHeaders();
        $requestApiKey = $headers->get($this->apiKeyParam, Yii::$app->getRequest()->get($this->apiKeyParam));
        
        if (null !== $this->api_key
            && $this->api_key != $requestApiKey
        ) {
            return $this->getNeedAuthResponse();
        }
        
        $this->clearCache();
        
        if ($this->cache !== null) {
            $cache = $this->getCache();
            if (($swagger = $cache->get($this->cacheKey)) === false) {
                $swagger = $this->getSwagger();
                $cache->set($this->cacheKey, $swagger);
            }
        } else {
            $swagger = $this->getSwagger();
        }


        $swaggerConfigDefault = [
            'schemes' => '{"http"}',
            'host' => 'yii2rest.test',
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
        ];

        $params = array_filter(array_column(Yii::$app->modules, 'params'));
        $swaggerConfig = array_column($params, 'swaggerConfig');
        $swaggerConfig = count($swaggerConfig) ? $swaggerConfig[0] : $swaggerConfigDefault;
        
        isset($swaggerConfig['schemes']) ? $swagger->schemes = $swaggerConfig['schemes'] : '';
        isset($swaggerConfig['host']) ? $swagger->host = $swaggerConfig['host'] : '';
        isset($swaggerConfig['basePath']) ? $swagger->basePath = $swaggerConfig['basePath'] : '';
        isset($swaggerConfig['info']) && isset($swaggerConfig['info']['title']) ? $swagger->info->title = $swaggerConfig['info']['title'] : '';
        isset($swaggerConfig['info']) && isset($swaggerConfig['info']['version']) ? $swagger->info->version = $swaggerConfig['info']['version'] : '';
        isset($swaggerConfig['info']) && isset($swaggerConfig['info']['description']) ? $swagger->info->description = $swaggerConfig['info']['description'] : '';
        isset($swaggerConfig['info']['contact']) && isset($swaggerConfig['info']) && isset($swaggerConfig['info']['contact']['name']) ? $swagger->info->contact->name = $swaggerConfig['info']['contact']['name'] : '';
        isset($swaggerConfig['info']['contact']) && isset($swaggerConfig['info']) && isset($swaggerConfig['info']['contact']['email']) ? $swagger->info->contact->email = $swaggerConfig['info']['contact']['email'] : '';
        
        return $swagger;
    }
    
    /**
     * Init cors.
     */
    protected function initCors()
    {
        $headers = Yii::$app->getResponse()->getHeaders();
        
        $headers->set('Access-Control-Allow-Headers', 'Content-Type, api_key, Authorization');
        $headers->set('Access-Control-Allow-Methods', 'GET, POST, DELETE, PUT');
        $headers->set('Access-Control-Allow-Origin', '*');
        $headers->set('Allow', 'OPTIONS,HEAD,GET');
    }
    
    /**
     * @return array
     */
    protected function getNeedAuthResponse()
    {
        return [
            'securityDefinitions' => [
                'api_key' => ['in' => 'header', 'type' => 'apiKey', 'name' => $this->apiKeyParam],
            ],
            'swagger' => '2.0',
            'schemes' => ['http'],
            'info' => [
                'title' => 'Please take authentication firstly.',
            ],
        ];
    }
    
    protected function clearCache()
    {
        $clearCache = Yii::$app->getRequest()->get('clear-cache', false);
        if ($clearCache !== false) {
            $this->getCache()->delete($this->cacheKey);
            
            Yii::$app->response->content = 'Succeed clear swagger api cache.';
            Yii::$app->end();
        }
    }
    
    /**
     * @return Cache
     * @throws \yii\base\InvalidConfigException
     */
    protected function getCache()
    {
        return is_string($this->cache) ? Yii::$app->get($this->cache, false) : $this->cache;
    }
    
    /**
     * Get swagger object
     *
     * @return \Swagger\Annotations\Swagger
     */
    protected function getSwagger()
    {
        return \Swagger\scan($this->scanDir, $this->scanOptions);
    }
}

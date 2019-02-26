<?php

use myzero1\rest\swagger\SwaggerUIAsset;

$swaggerConfigDefault = [
    'schemes' => '{"http"}',
    'host' => '"yii2rest.test"',
    'basePath' => '"/rest"',
    'info' => [
        'title' => '接口文档',
        'version' => '"1.0.0"',
        'description' => '"这是关于: __react-admin__（https://github.com/marmelab/react-admin/tree/master/packages/ra-data-simple-rest）的rest api"',
        'contact' => 'name = "myzero1", email = "myzero1@sina.com"',
    ]
];
$swaggerConfig = array_column(Yii::$app->modules, 'swaggerConfig1');
$swaggerConfig = count($swaggerConfig) ? $swaggerConfig : $swaggerConfigDefault;
/**
 * @SWG\Swagger(
 *     schemes={"http"},
 *     host="yii2rest.test",
 *     basePath="/rest",
 *     @SWG\Info(
 *         version="1.0.011",
 *         title="$swaggerConfig['info']['title']",
 *         description="Version: __1.0.022__",
 *         @SWG\Contact(name = "lichunqiang", email = "licq@lxpgw.com")
 *     ),
 * )
 *
 */

SwaggerUIAsset::register($this);
/** @var string $rest_url */
/** @var array $oauthConfig */
 ?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Swagger UI</title>
    <?php $this->head() ?>
    <script type="text/javascript">
        $(function () {
            var url = window.location.search.match(/url=([^&]+)/);
            if (url && url.length > 1) {
                url = decodeURIComponent(url[1]);
            } else {
                url = "<?= $rest_url ?>";
            }
            
            hljs.configure({
                highlightSizeThreshold: 5000
            });
            
            // Pre load translate...
            if(window.SwaggerTranslator) {
                window.SwaggerTranslator.translate();
            }
            window.swaggerUi = new SwaggerUi({
                url: url,
                dom_id: "swagger-ui-container",
                supportedSubmitMethods: ['options', 'head', 'get', 'post', 'put', 'delete', 'patch'],
                onComplete: function(swaggerApi, swaggerUi){
                    if(typeof initOAuth == "function") {
                        initOAuth(<?= json_encode($oauthConfig) ?>);
                    }
                    
                    if(window.SwaggerTranslator) {
                        window.SwaggerTranslator.translate();
                    }
                },
                onFailure: function(data) {
                    log("Unable to Load SwaggerUI");
                },
                docExpansion: "none",
                jsonEditor: false,
                defaultModelRendering: 'schema',
                showRequestHeaders: false,
                showOperationIds: false
            });
            
            window.swaggerUi.load();
            
            function log() {
                if ('console' in window) {
                    console.log.apply(console, arguments);
                }
            }
        });
    </script>
</head>

<body class="swagger-section">
<?php $this->beginBody() ?>
<div id='header'>
    <div class="swagger-ui-wrap">
        <a id="logo" href="http://swagger.io"><span class="logo__title">swagger</span></a>
        <form id='api_selector'>
            <div class='input'><input placeholder="http://example.com/api" id="input_baseUrl" name="baseUrl" type="text"/></div>
            <div id='auth_container'></div>
            <div class='input'><a id="explore" class="header__btn" href="#" data-sw-translate>Explore</a></div>
        </form>
    </div>
</div>

<div id="message-bar" class="swagger-ui-wrap" data-sw-translate>&nbsp;</div>
<div id="swagger-ui-container" class="swagger-ui-wrap"></div>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>

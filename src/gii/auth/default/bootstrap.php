<?php
/**
 * This is the template for generating CRUD search class of the specified model.
 */

use yii\helpers\StringHelper;

$ns = StringHelper::dirname(dirname(ltrim($generator->controllerClass, '\\')));

echo "<?php\n";
?>

namespace <?= $ns?>;

use yii\base\BootstrapInterface;

/**
 * v1 module definition class
 */
class Bootstrap implements BootstrapInterface
{
    /**
     * {@inheritdoc}
     */
    public function bootstrap($app)
    {

        $app->setModules([
            $this->params['moduleId'] => [
                'class' => str_replace('Bootstrap', 'Module', __CLASS__),
                'params' => $this->params,
            ]
        ]);

        $app->getUrlManager()->addRules([
            [
                'class' => 'yii\rest\UrlRule',
                'controller' => [
                    'v12/user'
                ],
                'pluralize' => false,
            ],
            [
                'class' => 'yii\rest\UrlRule',
                'controller' => ['v1/auth'],
                'pluralize' => false,
                'extraPatterns' => [
                    'POST login' => 'login',
                    'POST join' => 'join',
                    'GET info' => 'info',
                ],
            ],
        ], $append = false);
    }
}

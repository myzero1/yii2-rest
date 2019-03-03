<?php
/**
 * This is the template for generating CRUD search class of the specified model.
 */

use yii\helpers\StringHelper;

$ns = StringHelper::dirname(dirname(ltrim($generator->controllerClass, '\\')));
$rulesFile = Yii::getAlias('@' . str_replace('\\', '/', $ns)) . '/rules.php';

$moduleId = str_replace(StringHelper::dirname($ns).'\\', '', $ns);

echo "<?php\n";
?>

namespace <?= $ns?>;

use yii\base\BootstrapInterface;
use yii\helpers\StringHelper;

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
            '<?=$moduleId?>' => [
                'class' => str_replace('Bootstrap', 'Module', __CLASS__),
                'params' => $this->params,
            ]
        ]);

        $rules = require(\Yii::getAlias('@' . str_replace('\\', '/', StringHelper::dirname(__CLASS__))) . '/rules.php');
        $app->getUrlManager()->addRules($rules, $append = false);
    }
}

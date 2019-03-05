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
use yii\helpers\Json;

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

        $rulesFile = \Yii::getAlias('@' . str_replace('\\', '/', StringHelper::dirname(__CLASS__))) . '/rules.php';

        if (file_exists($rulesFile)) {
            $rulesTmp = require($rulesFile);
            $rulesStr1 = str_replace('Lw==', '/', $rulesTmp);
            $rulesStr2 = str_replace('XA==', '\\', $rulesStr1);
            $rulesStr = str_replace('IA==', ' ', $rulesStr2);
            $rules = Json::decode($rulesStr, $asArray = true);

            $app->getUrlManager()->addRules($rules, $append = false);
        }

    }
}

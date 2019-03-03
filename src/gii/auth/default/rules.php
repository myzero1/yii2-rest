<?php
/**
 * This is the template for generating CRUD search class of the specified model.
 */

use yii\helpers\StringHelper;

$nsp = StringHelper::dirname(dirname(ltrim($generator->controllerClass, '\\'))) . '\\models';

echo "<?php\n";
?>

namespace <?= $nsp . '\form'?>;

use Yii;
use yii\base\Model;
use <?= $nsp?>\Auth as User;
/**
 * REST URL config
 */

return [
    [
        'class' => 'yii\\rest\UrlRule',
        'controller' => 'v1/default',
        'only' => ['index'],
    ],
    [
        'class' => 'yii\\rest\UrlRule',
        'controller' => 'v1/$controllerName',
    ]
];
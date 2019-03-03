<?php
/**
 * This is the template for generating REST URL config.
 */

use yii\helpers\StringHelper;

$nsInfo = StringHelper::dirname(dirname(ltrim($generator->controllerClass, '\\')));
$nsInfoA = explode('\\', $nsInfo);
$moduleId = $nsInfoA[count($nsInfoA)-1];

echo "<?php\n";
?>

/**
 * REST URL config
 */

return [
    '<?=$moduleId?>/auth' => [
        'class' => 'yii\rest\UrlRule',
        'controller' => ['<?=$moduleId?>/auth'],
        'pluralize' => false,
        'extraPatterns' => [
            'POST login' => 'login',
            'POST join' => 'join',
            'GET info' => 'info',
        ],
    ],
];
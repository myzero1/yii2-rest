<?php
/**
 * This is the template for generating REST URL config.
 */

use yii\helpers\StringHelper;
use yii\helpers\Json;

$nsInfo = StringHelper::dirname(StringHelper::dirname(ltrim($generator->controllerClass, '\\')));
$nsInfoA = explode('\\', $nsInfo);
$moduleId = $nsInfoA[count($nsInfoA)-1];

$rulesFile = Yii::getAlias('@' . str_replace('\\', '/', $nsInfo)) . '/rules.php';
// var_dump($rulesFile);exit;
if (file_exists($rulesFile)) {
    $rulesTmp = require($rulesFile);
    $rulesStr1 = str_replace('Lw==', '/', $rulesTmp);
    $rulesStr2 = str_replace('XA==', '\\', $rulesStr1);
    $rulesStr = str_replace('IA==', ' ', $rulesStr2);
    $rules = Json::decode($rulesStr, $asArray = true);
}

$rules[$moduleId.'/auth'] = [
    'class' => 'yii\rest\UrlRule',
    'controller' => [$moduleId.'/auth'],
    'pluralize' => false,
    'extraPatterns' => [
        'POST login' => 'login',
        'POST join' => 'join',
        'GET info' => 'info',
    ],
];

$rulesStr1 = str_replace('/','Lw==', Json::encode($rules));
$rulesStr2 = str_replace('\\','XA==', $rulesStr1);
$rulesStr = str_replace(' ','IA==', $rulesStr2);

echo "<?php\n";
?>

/**
 * REST URL config
 */

return '<?=$rulesStr?>';
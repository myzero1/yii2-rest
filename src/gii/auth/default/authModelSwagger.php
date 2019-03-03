<?php
/**
 * This is the swagger's template of model.
 */

use yii\helpers\StringHelper;

$controllerClass = StringHelper::basename($generator->controllerClass);
$controllerName = str_replace('controller', '', strtolower($controllerClass)) . 's';

$properties = $generator->generateProperties($generator->tableName);
$rules = $generator->generateRules($generator->tableName);
$required = [];

foreach ($rules as $key => $value) {
    $value = json_decode(str_replace("'", '"', $value), true);
    if ($value[1] == 'required') {
        $required = $value[0];
    }
}

foreach ($properties as $property => $data) {
    if ($data['type'] == 'int') {
        $properties[$property]['type'] = 'integer';
    }
}

unset($properties['id']);

$modelClass1 = str_replace('_', ' ', $generator->tableName);
$modelClass2 = ucwords($modelClass1);
$modelClass3 = str_replace(' ', '', $modelClass2);

echo "<?php\n";
?>

/**
    @SWG\Tag(
        name="<?= $controllerName ?>",
        description="<?= $controllerName ?>",
        @SWG\ExternalDocumentation(
            description="Find out more about our store",
            url="http://swagger.io"
        )
    )
 */

/**
    @SWG\Definition(
        definition="<?= $modelClass3 ?>",
        required={"<?= implode('","', $required) ?>"},

    <?php foreach ($properties as $property => $data): ?>
    @SWG\Property(
            property="<?= $property ?>",
            type="<?= $data['type'] ?>",
            description="<?= $property ?>",
            example="<?= $data['type']=='integer' ? time() : $property ?>"
        ),
    <?php endforeach; ?>

    )
 */
<?php
/**
 * This is the swagger's template of model.
 */

use yii\helpers\StringHelper;

$controllerClass = StringHelper::basename($generator->controllerClass);
// $controllerName = str_replace('controller', '', strtolower($controllerClass)) . 's';
$controllerName = str_replace('controller', '', strtolower($controllerClass));

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
$modelTag = lcfirst($modelClass3);

$controllerName = str_replace('_', '-', $generator->tableName);

echo "<?php\n";
?>
/**
     @SWG\Get(path="/<?= $controllerName ?>",
         tags={"<?= $modelTag ?>"},
         summary="record list",
         description="Record list: actionIndex GET_LIST GET /<?= $controllerName ?>?sort=[""id"",""ASC""]&range=[0, 2]&filter={""status"":""10"",""ids"":[1,3,5]}",
         produces={"application/json"},
     
         @SWG\Parameter(
            in = "header",
            name = "Authorization",
            description = "Authorization",
            required = true,
            type = "string",
            default = "Bearer MM029y0i0yTqJFuzBMZXMRGU2VBMK32a_1551337412",
         ),
         @SWG\Parameter(
            in = "query",
            name = "sort",
            description = "sort",
            required = false,
            type = "string",
            default = "[""id"",""ASC""]",
         ),
         @SWG\Parameter(
            in = "query",
            name = "range",
            description = "range",
            required = false,
            type = "string",
            default = "[0, 10]",
         ),
         @SWG\Parameter(
            in = "query",
            name = "filter",
            description = "filter",
            required = false,
            type = "string",
            default = "{""id"":""1"",""ids"":[1,3,5]}",
         ),
     
         @SWG\Response(
             response = 200,
             description = "success"
         )
     )
     
     
     
     @SWG\Get(path="/<?= $controllerName ?>/{id}",
         tags={"<?= $modelTag ?>"},
         summary="record view",
         description="Record list: actionView GET_ONE GET /<?= $controllerName ?>/1",
         produces={"application/json"},
     
         @SWG\Parameter(
            in = "header",
            name = "Authorization",
            description = "Authorization",
            required = true,
            type = "string",
            default = "Bearer MM029y0i0yTqJFuzBMZXMRGU2VBMK32a_1551337412",
         ),
         @SWG\Parameter(
            in = "path",
            name = "id",
            description = "record id",
            required = true,
            type = "integer",
            default = 1,
         ),
     
         @SWG\Response(
             response = 200,
             description = "success"
         )
     )
     
     
     
     @SWG\Post(path="/<?= $controllerName ?>",
         tags={"<?= $modelTag ?>"},
         summary="record create",
         description="Record create: actionCreate CREATE Post /<?= $controllerName ?>",
         produces={"application/json"},

         @SWG\Parameter(
            in = "header",
            name = "Authorization",
            description = "Authorization",
            required = true,
            type = "string",
            default = "Bearer MM029y0i0yTqJFuzBMZXMRGU2VBMK32a_1551337412",
         ),
         @SWG\Parameter(
            in = "body",
            name = "body",
            description = "record content",
            required = true,
            type = "string",
            @SWG\Schema(ref = "#/definitions/User")
         ),
     
         @SWG\Response(
             response = 200,
             description = "success"
         )
     )
     
     
     
     @SWG\Put(path="/<?= $controllerName ?>/{id}",
         tags={"<?= $modelTag ?>"},
         summary="record update",
         description="Record update: actionUpdate UPDATE PUT /<?= $controllerName ?>/1",
         produces={"application/json"},
     
         @SWG\Parameter(
            in = "header",
            name = "Authorization",
            description = "Authorization",
            required = true,
            type = "string",
            default = "Bearer MM029y0i0yTqJFuzBMZXMRGU2VBMK32a_1551337412",
         ),
         @SWG\Parameter(
            in = "path",
            name = "id",
            description = "record id",
            required = true,
            type = "integer",
            default = 1,
         ),
         @SWG\Parameter(
            in = "body",
            name = "body",
            description = "update content",
            required = true,
                type = "string",
            @SWG\Schema(ref = "#/definitions/User")
         ),
     
         @SWG\Response(
             response = 200,
             description = "success"
         )
     )
     
     
     
     @SWG\Delete(path="/<?= $controllerName ?>/{id}",
         tags={"<?= $modelTag ?>"},
         summary="record delete",
         description="Record delete: actionDelete DELETE DELETE  /<?= $controllerName ?>/1",
         produces={"application/json"},

         @SWG\Parameter(
            in = "header",
            name = "Authorization",
            description = "Authorization",
            required = true,
            type = "string",
            default = "Bearer MM029y0i0yTqJFuzBMZXMRGU2VBMK32a_1551337412",
         ),
         @SWG\Parameter(
            in = "path",
            name = "id",
            description = "record id",
            required = true,
            type = "integer",
            default = 1,
         ),
     
         @SWG\Response(
             response = 200,
             description = "success"
         )
     )
 */
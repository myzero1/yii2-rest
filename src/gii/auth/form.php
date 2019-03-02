<?php
/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $generator yii\gii\generators\crud\Generator */

// echo $form->field($generator, 'modelClass');
// echo $form->field($generator, 'searchModelClass');
echo $form->field($generator, 'controllerClass');
echo $form->field($generator, 'baseControllerClass');
// echo $form->field($generator, 'apiConfig');
// echo $form->field($generator, 'userTable')->textInput(['table_prefix' => $generator->getTablePrefix()]);
echo $form->field($generator, 'tableName')->textInput(['table_prefix' => $generator->getTablePrefix()]);
echo $form->field($generator, 'userNameFieldGroup1');
echo $form->field($generator, 'userNameFieldGroup2');
echo $form->field($generator, 'userNameFieldGroup3');
echo $form->field($generator, 'userFieldPassword');

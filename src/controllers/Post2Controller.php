<?php

namespace myzero1\rest\controllers;
use myzero1\rest\components\ApiController;
use api\models\Post;

class Post2Controller extends ApiController
{
    public $modelClass = Post::class;
}
<?php
namespace myzero1\rest\swaggertools\config;

/**
 * @SWG\Swagger(
 *     schemes={"http"},
 *     host="yii2rest.test",
 *     basePath="/rest",
 *     @SWG\Info(
 *         version="1.0.0",
 *         title="接口文档",
 *         description="Version: __1.0.0__",
 *         @SWG\Contact(name = "myzero1", email = "myzero1@sina.com")
 *     ),
 * )
 *
 * @SWG\Tag(
 *   name="user",
 *   description="用户相关操作",
 *   @SWG\ExternalDocumentation(
 *     description="Find out more about our store",
 *     url="http://swagger.io"
 *   )
 * )
 */

/**
 * @SWG\Definition(
 *   @SWG\Xml(name="##default")
 * )
 */
class ApiResponse
{
    /**
     * @SWG\Property(format="int32", description = "code of result")
     * @var int
     */
    public $code;
    /**
     * @SWG\Property
     * @var string
     */
    public $type;
    /**
     * @SWG\Property
     * @var string
     */
    public $message;
    /**
     * @SWG\Property(format = "int64", enum = {1, 2})
     * @var integer
     */
    public $status;
}

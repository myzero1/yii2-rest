<?php
/**
 * This is the template for generating CRUD search class of the specified model.
 */

use yii\helpers\StringHelper;

$ns = StringHelper::dirname(StringHelper::dirname(ltrim($generator->controllerClass, '\\'))) . '\\models';

$where = [];
if (trim($generator->userNameFieldGroup1)) {
    $where[] = sprintf('%s = :username', trim($generator->userNameFieldGroup1));
}
if (trim($generator->userNameFieldGroup2)) {
    $where[] = sprintf('%s = :username', trim($generator->userNameFieldGroup2));
}
if (trim($generator->userNameFieldGroup3)) {
    $where[] = sprintf('%s = :username', trim($generator->userNameFieldGroup3));
}

$whereStr = implode(' OR ', $where);

echo "<?php\n";
?>

namespace <?= $ns?>;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\web\IdentityInterface;
use yii\filters\RateLimitInterface;

class Auth extends ActiveRecord implements IdentityInterface, RateLimitInterface
{
    public $authKey;
    public $accessToken;

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ]
            ]
        ];
    }

    # 速度控制  2秒内访问3次，注意，数组的第一个不要设置1，设置1会出问题，一定要
    #大于2，譬如下面  2秒内只能访问三次
    # 文档标注：返回允许的请求的最大数目及时间，例如，[100, 600] 表示在600秒内最多100次的API调用。
    public  function getRateLimit($request, $action){
        $nsInfo = explode('\\', __CLASS__);
        $moduleId = $nsInfo[count($nsInfo)-3];
        $rateLimit = Yii::$app->modules[$moduleId]->params['rateLimit'];
        return $rateLimit;
        // return Yii::$app->params['rateLimit'];
    }

    # 文档标注： 返回剩余的允许的请求和相应的UNIX时间戳数 当最后一次速率限制检查时。
    public  function loadAllowance($request, $action){
        //return [1,strtotime(date("Y-m-d H:i:s"))];
        //echo $this->allowance;exit;
        return [$this->allowance, $this->allowance_updated_at];
    }

    # allowance 对应user 表的allowance字段  int类型
    # allowance_updated_at 对应user allowance_updated_at  int类型
    # 文档标注：保存允许剩余的请求数和当前的UNIX时间戳。
    public  function saveAllowance($request, $action, $allowance, $timestamp){
        $this->allowance = $allowance;
        $this->allowance_updated_at = $timestamp;
        $this->save();
    }

    //表名
    public static function tableName()
    {
        return "{{%user}}";
    }

    //规则
    public function rules()
    {
        return [
            ['username', 'required', 'message' => '用户名不能为空'],
            ['api_token', 'required', 'message' => 'api_token不能为空']
        ];
    }

    /**
     * 生成 "remember me" 认证key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * 生成 api_token
     */
    public function generateApiToken()
    {
        $this->api_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * 校验api_token是否有效
     */
    public static function apiTokenIsValid($token)
    {
        if (empty($token)) {
            return false;
        }
        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        // $expire = Yii::$app->params['user.apiTokenExpire'];
        $nsInfo = explode('\\', __CLASS__);
        $moduleId = $nsInfo[count($nsInfo)-3];
        $expire = Yii::$app->modules[$moduleId]->params['apiTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * 根据api token 获取用户
     * @param $token
     * @return array|null|ActiveRecord
     */
    public static function findByApiToken($token)
    {
        return static::find()->where('api_token = :api_token', [':api_token' => $token])->one();
    }

    /**
     * 根据用户名查询用户
     * @param $username
     * @return array|null|ActiveRecord
     */
    public static function findByUsername($username)
    {
        // return static::find()->where('username = :username', [':username' => $username])->one();

        return static::find()->where('<?=$whereStr?>', [':username' => $username])->one();
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        // 如果token无效的话
        if(!static::apiTokenIsValid($token)) {
            throw new \yii\web\UnauthorizedHttpException("token is invalid.");
        }
        return static::findOne(['api_token' => $token]);
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->authKey;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }

    /**
     * 为model的password_hash字段生成密码的hash值
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password, $password_hash)
    {
        return Yii::$app->security->validatePassword($password, $password_hash);
    }
}
<?php

namespace myzero1\rest\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;

/**
 *
 * @SWG\Definition(
 *      definition="User",
 *      required={"username", "auth_key", "password_hash", "email"},
 *      @SWG\Property(
 *          property="username",
 *          type="string",
 *          description="Username",
 *          example="myzero1"
 *      ),
 *      @SWG\Property(
 *          property="auth_key",
 *          type="string",
 *          description="auth_key",
 *          example="auth_key"
 *      ),
 *      @SWG\Property(
 *          property="password_hash",
 *          type="string",
 *          description="password_hash",
 *          example="password_hash"
 *      ),
 *      @SWG\Property(
 *          property="email",
 *          type="string",
 *          description="email",
 *          example="email"
 *      ),
 * )
 *
 *
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $username
 * @property string $auth_key
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 * @property string $api_token
 * @property int $allowance
 * @property int $allowance_updated_at
 */
class User extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['username', 'auth_key', 'password_hash', 'email'], 'required'],
            [['status', 'created_at', 'updated_at', 'allowance', 'allowance_updated_at'], 'integer'],
            [['username', 'password_hash', 'password_reset_token', 'email', 'api_token'], 'string', 'max' => 255],
            [['auth_key'], 'string', 'max' => 32],
            [['username'], 'unique'],
            [['email'], 'unique'],
            [['password_reset_token'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'auth_key' => 'Auth Key',
            'password_hash' => 'Password Hash',
            'password_reset_token' => 'Password Reset Token',
            'email' => 'Email',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'api_token' => 'Api Token',
            'allowance' => 'Allowance',
            'allowance_updated_at' => 'Allowance Updated At',
        ];
    }

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
}

<?php
/**
 * This is the template for generating a CRUD controller class file.
 */

use yii\db\ActiveRecordInterface;
use yii\helpers\StringHelper;


/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

$controllerClass = StringHelper::basename($generator->controllerClass);
$modelClass = StringHelper::basename($generator->modelClass);
$searchModelClass = StringHelper::basename($generator->searchModelClass);
if ($modelClass === $searchModelClass) {
    $searchModelAlias = $searchModelClass . 'Search';
}

$prefix = StringHelper::dirname(dirname(ltrim($generator->controllerClass, '\\')));

$modelClass1 = str_replace('_', ' ', $generator->tableName);
$modelClass2 = ucwords($modelClass1);
$modelClass3 = str_replace(' ', '', $modelClass2);

echo "<?php\n";
?>

namespace <?= StringHelper::dirname(ltrim($generator->controllerClass, '\\')) ?>;

use Yii;
use yii\data\ActiveDataProvider;
use yii\rest\ActiveController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

use <?= sprintf('%s\%s', $prefix, 'components\BasicController') ?>;
use <?= sprintf('%s\%s', $prefix, 'models\form\LoginForm') ?>;
use <?= sprintf('%s\models\%s as User', $prefix, $modelClass3) ?>;

/**
 * AuthController implements the CRUD actions for User model.
 */
class AuthController extends BasicController
{
    public $modelClass = '';

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['access'] = [
            'class' => AccessControl::className(),
            'rules' => [
                [
                    'actions' => ['login', 'join'],
                    'allow' => true,
                ],
                [
                    'actions' => ['info'],
                    'allow' => true,
                    'roles' => ['@'],
                ],
            ]
        ];
        $behaviors['verbs'] = [
            'class' => VerbFilter::className(),
            'actions' => [
                'login' => ['post'],
                'join' => ['post'],
                'info' => ['get'],
            ]
        ];

        return $behaviors;
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [];
    }

    /**
     * Join action.
     *
     * @return string
     */
    public function actionJoin()
    {
        $model = new User();
        if ($model->load(Yii::$app->getRequest()->getBodyParams(), '') && $model->save()) {
            $response = Yii::$app->getResponse();
            $response->setStatusCode(201);

            return [
                'code' => 200200,
                'msg' => 'success',
                'data' => $model,
            ];
        } elseif (!$model->hasErrors()) {
            return [
                'code' => 200200,
                'msg' => 'success',
                'data' => $model->errors,
            ];
        }
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin ()
    {
        $model = new LoginForm;
        $model->setAttributes(Yii::$app->request->post());
        if ($user = $model->login()) {
            return [
                'code' => 200200,
                'msg' => 'success',
                'data' => $user->api_token,
            ];
        } else {
            return [
                'code' => 200500,
                'msg' => 'errors',
                'data' => $model->errors,
            ];
        }
    }

    /**
     * Info action.
     *
     * @return string
     */
    public function actionInfo()
    {
        $user = $this->authenticate(Yii::$app->user, Yii::$app->request, Yii::$app->response);

        return [
            'code' => 200500,
            'msg' => '',
            'data' => $user,
        ];
    }
}
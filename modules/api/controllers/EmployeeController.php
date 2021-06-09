<?php


namespace app\modules\api\controllers;


use app\modules\api\models\ChangePassword;
use app\modules\api\resources\UserResource;
use app\rest\ActiveController;
use Yii;
use yii\db\ActiveRecord;
use yii\filters\AccessControl;
use yii\web\UploadedFile;

class EmployeeController extends ActiveController
{
    public $modelClass = UserResource::class;

    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['access'] = [
            'class' => AccessControl::class,
            'only' => ['index', 'create', 'delete', 'update'],
            'rules' => [
                [
                    'allow' => true,
                    'actions' => ['index', 'create', 'delete', 'update'],
                    //TODO roles
                ]
            ]
        ];

        return $behaviors;
    }

    /**
     * @return array
     */
    public function actions()
    {
        $actions = parent::actions();
        unset($actions['index']);

        return $actions;
    }

    /**
     * @return UserResource[]
     */
    public function actionIndex()
    {
        return UserResource::find()->where(['<>', 'id', Yii::$app->user->id])->all();
    }

    /**
     * @return array|ActiveRecord[]
     */
    public function actionActiveUsers($channelId)
    {
        return UserResource::findBySql("
            SELECT u2.* FROM users u2 LEFT JOIN (
                SELECT u.* FROM users u INNER JOIN user_channels uc on uc.user_id = u.id 
                WHERE uc.channel_id = :channelId) tmp ON tmp.id = u2.id
            WHERE tmp.id IS NULL", ['channelId' => $channelId])
            ->all();
    }

    /**
     * Get Current User
     */
    public function actionGetCurrentUser()
    {
        $user = Yii::$app->user->identity;
        $auth = Yii::$app->authManager;
        $permissions = $auth->getPermissionsByUser($user->id);

        return [
            'permissions' => $permissions,
            'currentUser' => UserResource::findOne(['id' => Yii::$app->user->id])
        ];
    }

    /**
     * Change current user password
     *
     * @return array|mixed
     */
    public function actionChangePassword()
    {
        $model = new ChangePassword();
        $model->user = Yii::$app->user->identity;
        if ($model->load(Yii::$app->request->post(), '') && $model->validate() && $model->changePassword()) {
            return $this->response(null, 204);
        }

        return $this->validationError($model->getFirstErrors());
    }

    /**
     * @return array|UserResource
     */
    public function actionUpdateProfile()
    {
        /** @var $user UserResource */
        $user = UserResource::findOne(['id' => Yii::$app->user->id]);
        $user->image = UploadedFile::getInstanceByName('image');
        if ($user->load(Yii::$app->request->post(), '') && $user->save()) {
            return $user;
        }

        return $user->getFirstErrors();
    }
}
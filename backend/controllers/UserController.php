<?php
/**
 * Created by PhpStorm.
 * User: klimandr
 * Date: 02.03.18
 * Time: 13:29
 */
namespace backend\controllers;

use yii\base\Module;
use common\models\User;
use Yii;
use yii\web\HttpException;
use common\services\UserService;
use common\services\AccessTokenService;
use yii\base\Exception;

class UserController extends RestController
{
    public $modelClass = User::class;
    private $userService;
    private $accessTokenService;

    public function __construct(
        string $id,
        Module $module,
        UserService $userService,
        AccessTokenService $accessTokenService,
        array $config = []
    ) {
        parent::__construct($id, $module, $config);
        $this->userService = $userService;
        $this->accessTokenService = $accessTokenService;
    }

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator']['except'] = ['create', 'authorize'];
        return $behaviors;
    }

    /**
     * Do authorization.
     * @return array|null|\yii\db\ActiveRecord created token and userId in model AccessToken or null
     * @throws HttpException if there is no such user
     * @throws \yii\base\Exception
     */
    public function actionAuthorize()
    {
        $request = Yii::$app->request;
        $response = Yii::$app->getResponse();
        $user = $this->userService->findUserByEmail($request->getBodyParam('email'));

        if ($user == null) {
            throw new HttpException(401,'Unauthorized. Check your login');
        }

        $isPasswordCorrect = $this->userService->validateUserPassword($user, $request->getBodyParam('password'));
        if (!$isPasswordCorrect) {
            throw new HttpException(401,'Unauthorized. Check your login/password');
        }

        $accessToken = $this->accessTokenService->findAccessTokenByUserId($user);

        try {
            $finalAccessToken = $this->accessTokenService->createOrUpdateAccessToken($user, $accessToken);
        } catch (Exception $e) {
            throw new HttpException(500, $e->getMessage());
        }

        $response->setStatusCode(201);

        return $finalAccessToken;
    }
}

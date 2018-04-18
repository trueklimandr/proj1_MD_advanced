<?php
/**
 * Created by PhpStorm.
 * User: klimandr
 * Date: 07.03.18
 * Time: 10:46
 */

namespace common\services;

use common\models\AccessToken;
use common\models\User;
use Yii;
use yii\base\Exception;

class AccessTokenService
{
    /**
     * @param \common\models\User $user
     * @return array|null
     */
    public function findAccessTokenByUserId(User $user)
    {
        return AccessToken::find()
            ->where(['userId' => $user->userId])
            ->one();
    }

    /**
     * @param User $user
     * @param AccessToken|null $accessToken
     * @return AccessToken|null
     * @throws \yii\base\Exception
     */
    public function createOrUpdateAccessToken(User $user, ?AccessToken $accessToken)
    {
        if ($accessToken == null) {
            $accessToken = new AccessToken();
            $accessToken->token = Yii::$app->security->generateRandomString();
            $accessToken->userId = $user->userId;
        } else {
            $accessToken->token = Yii::$app->security->generateRandomString();
        }

        if (!$accessToken->save() && !$accessToken->hasErrors()) {
            throw new Exception('Can\'t save accessToken');
        }
        return $accessToken;
    }
}

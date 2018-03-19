<?php
/**
 * Created by PhpStorm.
 * User: klimandr
 * Date: 07.03.18
 * Time: 10:46
 */

namespace common\services;

use Yii;
use common\models\User;

class UserService
{
    /**
     * @param string $email
     * @return array|null
     */
    public function findUserByEmail(string $email)
    {
        return User::find()
            ->where(['email' => $email])
            ->one();
    }

    /**
     * @param User $user
     * @param string $enteringPassword
     * @return bool
     */
    public function validateUserPassword(User $user, string $enteringPassword):bool
    {
        return Yii::$app->getSecurity()->validatePassword(
            $enteringPassword,
            $user->password
        );
    }
}

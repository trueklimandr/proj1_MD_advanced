<?php
/**
 * Created by PhpStorm.
 * User: klimandr
 * Date: 06.03.18
 * Time: 9:54
 */

namespace common\models;

use yii\db\ActiveRecord;

/**
 * Class AccessToken for table accessToken
 * @package common\models
 * @property string $token
 * @property int $userId
 */

class AccessToken extends ActiveRecord
{
    public static function tableName()
    {
        return 'accessToken';
    }

    public function getUser()
    {
        return $this->hasOne(User::class, ['userId' => 'userId']);
    }
}

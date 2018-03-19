<?php
/**
 * Created by PhpStorm.
 * User: klimandr
 * Date: 02.03.18
 * Time: 12:11
 */

namespace common\models;

use yii\db\ActiveRecord;
use yii;
use yii\web\IdentityInterface;

/**
 * Class Doctor for table doctor
 * @package app\models
 * @property int $userId
 * @property string $firstName
 * @property string $lastName
 * @property string $email
 * @property string $password
 * @property string $type
 */
class User extends ActiveRecord implements IdentityInterface
{
    /**
     * replace password with password hash in the table
     * @param bool $insert
     * @return bool
     * @throws yii\base\Exception
     */
    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }
        if ($this->isNewRecord) {
            $this->password = Yii::$app->getSecurity()->generatePasswordHash($this->password);
        }
        return true;
    }

    /**
     * @return array of rules of access to user table in DB
     */
    public function rules()
    {
        return [
            [['firstName', 'lastName', 'email', 'password', 'type'], 'safe'],
            [['firstName', 'lastName', 'email', 'password', 'type'], 'required'],
            ['type', 'in', 'range' => ['user', 'doctor']],
            ['email', 'email'],
            ['email', 'unique']
        ];
    }

    /**
     * this is "link" to foreign key in doctor
     * @return yii\db\ActiveQuery
     */
    public function getDoctor()
    {
        return $this->hasOne(Doctor::class, ['userId' => 'userId']);
    }

    /**
     * this is "link" to foreign key in accessToken
     * @return yii\db\ActiveQuery
     */
    public function getAccessToken()
    {
        return $this->hasOne(AccessToken::class, ['userId' => 'userId']);
    }

    /**
     * @param mixed $token
     * @param null $type
     * @return null|IdentityInterface|static
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        $accessToken = AccessToken::find()->where(['token' => $token])->one();
        return static::findOne(['userId' => $accessToken['userId']]);
    }

    /**
     * @return int|string userId
     */
    public function getId()
    {
        return $this->userId;
    }

    public static function findIdentity($id)
    {
        // TODO: Implement findIdentity() method.
    }

    public function getAuthKey()
    {
        // TODO: Implement getAuthKey() method.
    }

    public function validateAuthKey($authKey)
    {
        // TODO: Implement validateAuthKey() method.
    }
}

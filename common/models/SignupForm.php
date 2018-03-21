<?php
/**
 * Created by PhpStorm.
 * User: klimandr
 * Date: 20.03.18
 * Time: 15:54
 */

namespace common\models;

use yii\base\Model;

class SignupForm extends Model
{
    public $firstName;
    public $lastName;
    public $email;
    public $password;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['firstName', 'trim'],
            ['firstName', 'required'],
            ['firstName', 'string', 'min' => 2, 'max' => 255],

            ['lastName', 'trim'],
            ['lastName', 'required'],
            ['lastName', 'string', 'min' => 2, 'max' => 255],

            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This email address has already been taken.'],

            ['password', 'required'],
            ['password', 'string', 'min' => 6],
        ];
    }

    /**
     * Signs user up.
     *
     * @return bool|User
     */
    public function Signup()
    {
        if (!$this->validate()) {
            return false;
        }

        $user = new User();
        $user->firstName = $this->firstName;
        $user->lastName = $this->lastName;
        $user->email = $this->email;
        $user->password = $this->password;
        $user->type = 'user';

        return ($user->save()) ? $user : false;
    }
}

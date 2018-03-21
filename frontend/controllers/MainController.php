<?php
/**
 * Created by PhpStorm.
 * User: klimandr
 * Date: 20.03.18
 * Time: 9:39
 */

namespace frontend\controllers;

use common\models\Doctor;
use common\models\LoginForm;
use common\models\SignupForm;
use Yii;
use yii\web\Controller;

class MainController extends Controller
{
    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Logs in a user.
     *
     * @return string|\yii\web\Response
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goHome();
        } else {
            $model->password = '';

            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Shows about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    /**
     * Sign up a user.
     *
     * @return string|\yii\web\Response
     */
    public function actionSignup()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->Signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                }
            }
        }

        return $this->render('signup', ['model' => $model]);
    }

    /**
     * Show doctors list.
     *
     * @return string
     */
    public function actionRecord()
    {
        $doctors = Doctor::findBySql('SELECT * FROM doctor INNER JOIN user ON doctor.userId = user.userId ORDER BY lastName')->all();
        return $this->render('record', ['doctors' => $doctors]);
    }
}

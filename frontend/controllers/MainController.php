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
use common\models\TimeSlot;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\HttpException;

class MainController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['index', 'login', 'about', 'signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => [
                            'index',
                            'logout',
                            'about',
                            'record',
                            'get-slots',
                            'index-slots',
                            'add-slot',
                            'delete-slot',
                            'choose-record'
                        ],
                        'allow' => true,
                        'roles' => ['@'],
                    ]
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

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
    public function actionSignUp()
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

    /**
     * @return null|string list of timeSlots in JSON
     */
    public function actionGetSlots()
    {
        if (Yii::$app->user->isGuest) {
            return null;
        }

        $doctorId = Yii::$app->request->get('doctorId');
        $timeSlots = TimeSlot::find()
            ->where('doctorId='.$doctorId)
            ->orderBy(['date' => SORT_ASC, 'start' => SORT_ASC])
            ->all();
        return JSON::encode($timeSlots);
    }

    /**
     * Shows a list of existing slots for current (logged in) doctor
     * @return string
     * @throws HttpException if user is logged in as not doctor or not logged in at all
     */
    public function actionIndexSlots()
    {
        if (!$doctor = Yii::$app->user->identity->doctor) {
            throw new HttpException(401, 'No access. Please, log in as a doctor.');
        }

        $timeSlots = TimeSlot::find()
            ->where('doctorId='.$doctor->doctorId)
            ->orderBy(['date' => SORT_ASC, 'start' => SORT_ASC])
            ->all();
        return $this->render('index-slots', ['timeSlots' => $timeSlots, 'doctor' => $doctor]);
    }

    /**
     * Calls a form to add a new timeslot and then shows updated list of slots
     * @return string
     * @throws HttpException if user is logged in as not doctor or not logged in at all
     */
    public function actionAddSlot()
    {
        if (!$doctor = Yii::$app->user->identity->doctor) {
            throw new HttpException(401, 'No access. Please, log in as a doctor.');
        }

        $timeSlot = new TimeSlot();
        if ($timeSlot->load(Yii::$app->request->post())) {
            if ($timeSlot->save()) {
                $timeSlots = TimeSlot::find()
                    ->where('doctorId='.$doctor->doctorId)
                    ->orderBy(['date' => SORT_ASC, 'start' => SORT_ASC])
                    ->all();
                return $this->render('index-slots', ['timeSlots' => $timeSlots, 'doctor' => $doctor]);
            }
        }
        return $this->render('add-slot', [
            'timeSlot' => $timeSlot,
            'doctorId' => $doctor->doctorId,
            'crumbs' => Yii::$app->request->get()
        ]);
    }

    /**
     * Deletes specified slot and shows updated list of slots
     * @return string
     * @throws HttpException if user is logged in as not doctor or not logged in at all
     */
    public function actionDeleteSlot()
    {
        if (!$doctor = Yii::$app->user->identity->doctor) {
            throw new HttpException(401, 'No access. Please, log in as a doctor.');
        }

        if ($targetId = Yii::$app->request->get('id')) {
            TimeSlot::deleteAll(['id' => $targetId]);
            $timeSlots = TimeSlot::find()
                ->where('doctorId='.$doctor->doctorId)
                ->orderBy(['date' => SORT_ASC, 'start' => SORT_ASC])
                ->all();
            return $this->render('index-slots', ['timeSlots' => $timeSlots, 'doctor' => $doctor]);
        }
    }

    public function actionChooseRecord()
    {
        if ($slotId = Yii::$app->request->get('slotId')) {
            $slot = TimeSlot::find()
                ->where('id='.$slotId)
                ->orderBy(['date' => SORT_ASC, 'start' => SORT_ASC])
                ->all();
            $diff = $slot->end - $slot->start;
            return $this->render('choose-record', ['timeSlots' => $slot]);
        }
        throw new HttpException(400, 'SlotId is undefined.');
    }
}

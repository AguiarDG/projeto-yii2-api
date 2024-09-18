<?php

namespace app\controllers;

use app\models\User;
use Yii;
use yii\rest\ActiveController;
use yii\web\UnauthorizedHttpException;

class UserController extends ActiveController
{
    public $modelClass = 'app\models\User';


    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        $request = Yii::$app->request;
        $login = $request->post('login');
        $password = $request->post('password');

        $user = User::findOne(['login' => $login]);

        if ($user && $user->validatePassword($password)) {
            return ['access_token' => $user->access_token];
        } else {
            throw new UnauthorizedHttpException('Login ou senha invalido.');
        }
    }
}

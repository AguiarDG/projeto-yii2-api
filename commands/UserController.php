<?php

namespace app\commands;

use Yii;
use yii\console\Controller;
use yii\console\ExitCode;
use app\models\User;

class UserController extends Controller
{
    /**
     * Cria um novo usuário.
     *
     * @param string $login Nome de usuário
     * @param string $password Senha
     * @param string $username Nome completo
     * @return string
     */
    public function actionCreate($login, $password, $username)
    {
        $user = new User();
        $user->login = $login;
        $user->username = $username;
        $user->setPassword($password);
        $user->generateAccessToken();

        if ($user->save()) {
            echo "Usuário criado com sucesso: \n";
            print_r($user->getAttributes());
            echo "\n";
            return ExitCode::OK;
        } else {
            echo "Erro ao criar o usuário:\n";
            print_r($user->getErrors());  // Exibe os erros de validação
            return ExitCode::UNSPECIFIED_ERROR;
        }
    }
}

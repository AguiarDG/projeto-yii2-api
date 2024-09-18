<?php

namespace app\controllers;

use Yii;
use yii\rest\ActiveController;
use yii\data\ActiveDataProvider;
use yii\filters\auth\HttpBearerAuth;
use app\models\Cliente;

class ClienteController extends ActiveController
{
    public $enableCsrfValidation = false;
    public $modelClass = 'app\models\Cliente';


    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => HttpBearerAuth::class
        ];
        return $behaviors;
    }

    public function actions()
    {
        $actions = parent::actions();
        // Remove a ação 'index' padrão
        unset($actions['index'], $actions['delete']);
        return $actions;
    }

    public function actionIndex()
    {
        $queryParams = Yii::$app->request->queryParams;

        $query = Cliente::find();

        // Filtros
        if (!empty($queryParams['nome'])) {
            $query->andFilterWhere(['like', 'nome', $queryParams['nome']]);
        }
        if (!empty($queryParams['cpf'])) {
            $query->andFilterWhere(['cpf' => $queryParams['cpf']]);
        }

        // Ordenação
        $sort = isset($queryParams['sort']) ? $queryParams['sort'] : 'id';
        $sort = in_array($sort, ['nome', 'cpf', 'cidade']) ? $sort : 'id'; // Verifica se o campo de ordenação é válido
        $query->orderBy([$sort => SORT_ASC]);

        // Paginação
        $limit = isset($queryParams['limit']) ? (int)$queryParams['limit'] : 20; // Default para 20
        $offset = isset($queryParams['offset']) ? (int)$queryParams['offset'] : 0; // Default para 0

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => $limit,
                'page' => $offset / $limit, // Calcula a página a partir do offset
            ],
        ]);

        return $dataProvider;
    }

    public function actionDelete($id)
    {
        $model = Cliente::findIdentity($id);

        if ($model->delete()) {
            return $this->asJson([
                'success' => true,
                'message' => 'Registro deletado com sucesso.'
            ]);
        } else {
            return $this->asJson([
                'success' => false,
                'message' => 'Erro ao deletar o registro.'
            ]);
        }
    }
}

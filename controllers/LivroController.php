<?php

namespace app\controllers;

use app\models\Livro;
use Yii;
use yii\data\ActiveDataProvider;
use yii\rest\ActiveController;

use yii\filters\auth\HttpBasicAuth;
use yii\filters\auth\HttpBearerAuth;

class LivroController extends ActiveController
{
    public $enableCsrfValidation = false;
    public $modelClass = 'app\models\Livro';


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
        unset($actions['index']);
        return $actions;
    }

    public function actionIndex()
    {
        $queryParams = Yii::$app->request->queryParams;

        $query = Livro::find();

        // Filtros
        if (!empty($queryParams['titulo'])) {
            $query->andFilterWhere(['like', 'titulo', $queryParams['titulo']]);
        }
        if (!empty($queryParams['autor'])) {
            $query->andFilterWhere(['autor' => $queryParams['autor']]);
        }

        // Ordenação
        $sort = isset($queryParams['sort']) ? $queryParams['sort'] : 'id';
        $sort = in_array($sort, ['titulo', 'preco']) ? $sort : 'id'; // Verifica se o campo de ordenação é válido
        $query->orderBy([$sort => SORT_ASC]);

        // Paginação
        $limit = isset($queryParams['limit']) ? (int)$queryParams['limit'] : 20; // Default limit 20
        $offset = isset($queryParams['offset']) ? (int)$queryParams['offset'] : 0; // Default offset 0

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => $limit,
                'page' => $offset / $limit, // Calcula a página a partir do offset
            ],
        ]);

        return $dataProvider;
    }
}

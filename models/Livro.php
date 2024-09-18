<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\httpclient\Client;

class Livro extends ActiveRecord
{
    public static function tableName()
    {
        return 'livros'; // Nome da tabela no banco de dados
    }

    public function rules()
    {
        return [
            [['isbn', 'titulo', 'autor', 'preco', 'estoque'], 'required'],
            [['isbn'], 'string', 'max' => 20, 'tooLong' => 'ISBN deve conter no máximo 20 caracteres.'],
            [['titulo'], 'string', 'max' => 100, 'tooLong' => 'Titulo deve conter no máximo 100 caracteres.'],
            [['autor'], 'string', 'max' => 100, 'tooLong' => 'Autor deve conter no máximo 100 caracteres.'],
            [['preco'], 'number', 'max' => 12, 'tooBig' => 'Preço deve conter no máximo 12 caracteres.'],
            [['estoque'], 'number', 'max' => 20, 'tooBig' => 'Estoque deve conter no máximo 20 caracteres.'],
            [['isbn'], 'validateIsbn']
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'isbn' => 'ISBN',
            'titulo' => 'Titulo',
            'autor' => 'Auto',
            'preco' => 'Preço',
            'estoque' => 'Estoque'
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Função para validar o campo ISBN
     * 
     * {@inheritdoc}
     * @param mixed $attribute
     * @return void
     */
    public function validateIsbn($attribute)
    {
        $isValid = $this->isValidIsbn($this->$attribute);
        if (!$isValid["success"]) {
            $this->addError($attribute, $isValid["msg"]);
        }
    }

    /**
     * Valida se o campo ISBN é válido
     *
     * @param string $isbn ISBN a validar
     * @return array Se o ISBN é válido
     */
    public function isValidIsbn($isbn)
    {
        // Faz a requisição para a BrasilAPI
        $client = new Client();
        $response = $client->createRequest()
            ->setMethod('GET')
            ->setUrl("https://brasilapi.com.br/api/isbn/v1/{$isbn}")
            ->send();

        if ($response === false) {
            return [
                "success" => false,
                "msg" => "Erro ao validar o ISBN. Não foi possível conectar à API."
            ];
        }

        $data = json_decode($response->getContent());

        // Verifica se o ISBN é válido de acordo com a API
        if (isset($data->message) && $data->message == 'ISBN inválido') {
            return [
                "success" => false,
                "msg" => "ISBN inválido de acordo com a validação da BrasilAPI."
            ];
        }
        return [
            "success" => true
        ];
    }
}

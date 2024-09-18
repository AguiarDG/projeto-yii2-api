<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\httpclient\Client;

class Cliente extends ActiveRecord
{
    public static function tableName()
    {
        return 'clientes';
    }

    public function rules()
    {
        return [
            [['nome', 'cpf', 'sexo', 'cep', 'logradouro', 'numero', 'bairro', 'cidade', 'estado'], 'required'],
            [['nome'], 'string', 'max' => 100, 'tooLong' => 'Nome deve conter no máximo 100 caracteres.'],
            [['cpf'], 'string', 'length' => 11, 'min' => 11, 'tooLong' => 'CPF deve conter 11 caracteres.', 'tooShort' => 'CPF deve conter 11 caracteres.'],
            [['sexo'], 'string', 'length' => 1, 'min' => 1, 'max' => 1, 'tooLong' => 'Sexo deve conter 1 caracteres.', 'tooShort' => 'Sexo deve conter 1 caracteres.'],
            [['cep'], 'string', 'min' => 1, 'max' => 8, 'tooLong' => 'Cep deve conter no máximo 50 caracteres.'],
            [['logradouro'], 'string', 'max' => 150, 'tooLong' => 'Logradouro should contain 150 characters.'],
            [['numero'], 'string', 'max' => 50, 'tooLong' => 'Numero deve conter no máximo 50 caracteres.'],
            [['bairro'], 'string', 'max' => 100, 'tooLong' => 'Bairro deve conter no máximo 100 caracteres.'],
            [['cidade'], 'string', 'max' => 100, 'tooLong' => 'Cidade deve conter no máximo 100 caracteres.'],
            [['estado'], 'string', 'max' => 100, 'tooLong' => 'Estado deve conter no máximo 100 caracteres.'],
            [['complemento'], 'string', 'max' => 150, 'tooLong' => 'Complemento deve conter no máximo 100 caracteres.'],
            [['sexo'], 'in', 'range' => ['M', 'F']],
            [['cpf'], 'validateCpf'],
            [['cep'], 'validateCep'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nome' => 'Nome',
            'cpf' => 'CPF',
            'sexo' => 'Sexo',
            'cep' => 'Cep',
            'logradouro' => 'Endereço',
            'numero' => 'Numero',
            'bairro' => 'Bairro',
            'cidade' => 'Cidade',
            'estado' => 'Estado',
            'complemento' => 'Complemento',
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
     * Função para validar o CPF
     * 
     * {@inheritdoc}
     */
    public function validateCpf($attribute)
    {
        if (!$this->isValidCpf($this->$attribute)) {
            $this->addError($attribute, 'CPF inválido.');
        }
    }

    /**
     * Função que verifica se o CPF é válido
     * 
     * @param string $cpf CPF a ser validado
     * @return bool Se o CPF é válido ou não
     */
    public function isValidCpf($cpf)
    {
        // Remove caracteres especiais
        $cpf = preg_replace('/[^0-9]/', '', $cpf);

        // Verifica se tem 11 dígitos
        if (strlen($cpf) != 11) {
            return false;
        }

        // Verifica se todos os dígitos são iguais (ex: 111.111.111-11)
        if (preg_match('/(\d)\1{10}/', $cpf)) {
            return false;
        }

        // Cálculo dos dígitos verificadores
        for ($t = 9; $t < 11; $t++) {
            for ($d = 0, $c = 0; $c < $t; $c++) {
                $d += $cpf[$c] * (($t + 1) - $c);
            }
            $d = ((10 * $d) % 11) % 10;
            if ($cpf[$c] != $d) {
                return false;
            }
        }

        return true;
    }

    // 
    /**
     * Validação para o CEP usando a BrasilAPI
     * 
     * @param string $cpf CPF a ser validado
     * @return bool Se o CPF é válido ou não
     */
    public function validateCep($attribute, $params, $validator)
    {
        if (!$this->isValidCep($this->$attribute)) {
            $this->addError($attribute, 'CEP inválido.');
        }
    }

    /**
     * Função para verificar se o CEP é válido usando BrasilAPI
     * 
     * @param string $cep CEP a ser validado
     * @return bool Se o CEP é válido ou não
     */
    public function isValidCep($cep)
    {
        // Remove caracteres não numéricos do CEP
        $cep = preg_replace('/[^0-9]/', '', $cep);

        // Verifica se tem 8 dígitos
        if (strlen($cep) != 8) {
            return false;
        }

        // Faz a requisição para a BrasilAPI
        $client = new Client();
        $response = $client->createRequest()
            ->setMethod('GET')
            ->setUrl("https://brasilapi.com.br/api/cep/v2/{$cep}")
            ->send();

        if ($response->isOk) {
            // CEP válido
            return true;
        } else {
            // CEP inválido ou não encontrado
            return false;
        }
    }
}

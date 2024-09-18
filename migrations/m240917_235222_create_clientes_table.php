<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%clientes}}`.
 */
class m240917_235222_create_clientes_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%clientes}}', [
            'id' => $this->primaryKey(),
            'nome' => $this->string(150)->notNull()->collation('utf8mb4_general_ci'),
            'sexo' => $this->char(1)->notNull()->collation('utf8mb4_general_ci'),
            'cpf' => $this->string(20)->notNull()->collation('utf8mb4_general_ci'),
            'cep' => $this->string(15)->notNull()->collation('utf8mb4_general_ci'),
            'logradouro' => $this->string(150)->notNull()->collation('utf8mb4_general_ci'),
            'numero' => $this->string(50)->notNull()->collation('utf8mb4_general_ci'),
            'bairro' => $this->string(100)->notNull()->collation('utf8mb4_general_ci'),
            'cidade' => $this->string(100)->notNull()->collation('utf8mb4_general_ci'),
            'estado' => $this->string(100)->notNull()->collation('utf8mb4_general_ci'),
            'complemento' => $this->string(150)->null()->defaultValue(null)->collation('utf8mb4_general_ci'),
            'created_at' => $this->dateTime()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->dateTime()->notNull()->defaultExpression('CURRENT_TIMESTAMP')->append('ON UPDATE CURRENT_TIMESTAMP'),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%clientes}}');
    }
}

<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%livros}}`.
 */
class m240917_235232_create_livros_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%livros}}', [
            'id' => $this->primaryKey(),
            'isbn' => $this->string(20)->notNull()->collation('utf8mb4_general_ci'),
            'titulo' => $this->string(100)->notNull()->collation('utf8mb4_general_ci'),
            'autor' => $this->string(100)->notNull()->collation('utf8mb4_general_ci'),
            'preco' => $this->float(12)->notNull(),
            'estoque' => $this->integer(20)->notNull()->defaultValue(0),
            'created_at' => $this->dateTime()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->dateTime()->notNull()->defaultExpression('CURRENT_TIMESTAMP')->append('ON UPDATE CURRENT_TIMESTAMP'),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%livros}}');
    }
}

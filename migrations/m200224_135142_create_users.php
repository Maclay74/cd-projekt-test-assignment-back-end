<?php

use yii\db\Migration;

/**
 * Class m200224_135142_create_users
 */
class m200224_135142_create_users extends Migration {
    /**
     * {@inheritdoc}
     */
    public function safeUp() {
        $this->createTable('users', [
            'id' => $this->primaryKey()->comment("ID"),
            'login' => $this->string(50)->notNull()->comment("Login"),
            'password' => $this->string(255)->notNull()->comment("Password"),
        ]);

        $this->insert('users', [
            'login' => 'admin',
            'password' => \Yii::$app->security->generatePasswordHash('password')
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() {
        $this->dropTable('users');
        echo "m200224_135142_create_users has been reverted.\n";
        return true;
    }

}

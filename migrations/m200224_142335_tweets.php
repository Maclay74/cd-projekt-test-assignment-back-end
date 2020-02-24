<?php

use yii\db\Migration;

/**
 * Class m200224_142335_tweets
 */
class m200224_142335_tweets extends Migration {
    /**
     * {@inheritdoc}
     */
    public function safeUp() {

        $this->createTable('tweets', [
            'id' => $this->primaryKey()->comment("ID"),
            'title' => $this->string(140)->comment('Title'),
            'description' => $this->string(200)->comment('Description'),
            'author_name' => $this->string(100)->comment('Author Name'),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'publish_date' => $this->dateTime()
        ]);

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() {

        $this->dropTable('tweets');

        echo "m200224_142335_tweets has been reverted.\n";
        return true;
    }


}

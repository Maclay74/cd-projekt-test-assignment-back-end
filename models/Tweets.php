<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tweets".
 *
 * @property int $id ID
 * @property string|null $title Title
 * @property string|null $description Description
 * @property string|null $author_name Author Name
 * @property string $created_at
 * @property string|null $publish_date
 */
class Tweets extends \yii\db\ActiveRecord {
    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'tweets';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'description', 'publish_date', 'author_name'], 'required'],
            [['created_at', 'publish_date'], 'safe'],
            [['title'], 'string', 'max' => 140],
            [['description'], 'string', 'max' => 200],
            [['author_name'], 'string', 'max' => 100],
            [['publish_date'], 'date', 'format' => 'yyyy-M-d H:m:s']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'description' => 'Description',
            'author_name' => 'Author Name',
            'created_at' => 'Created At',
            'publish_date' => 'Public Date',
        ];
    }
}

<?php

namespace app\modules\api\controllers;

use app\components\ApiController;
use app\models\LoginForm;
use app\models\Tweets;
use yii\filters\auth\HttpBearerAuth;

class TweetsController extends ApiController {

     const SORT_PUBLISH_DATE = 'publish_date';
     const SORT_TITLE = 'title';

    public function behaviors() {
        return array_merge(parent::behaviors(), [
            'authenticator' => [
                'class' => HttpBearerAuth::class,
                'except' => ['index'],
            ],
        ]);
    }

    public function actionIndex($page = 0, $pageSize = 10, $sort = null) {
        $tweets = Tweets::find()
            ->select(['id', 'title', 'description', 'publish_date']);

        $count = $tweets->count();
        $tweets->limit($pageSize)
            ->offset($page * $pageSize - $pageSize);

        switch ($sort) {
            case self::SORT_PUBLISH_DATE:
                $tweets->orderBy('publish_date desc');
                break;
            case self::SORT_TITLE:
                $tweets->orderBy('title asc');
                break;
        }

        return ['tweets' => $tweets->all(), 'count' => $count];
    }

    public function actionUpload() {

        $requestBody = json_decode(file_get_contents('php://input'));

        foreach ($requestBody->tweets as $tweet) {
            $model = new Tweets();
            $model->attributes = get_object_vars($tweet);
            $model->save();
        }

        return ['result' => true];
    }

    public function actionTruncate() {
        Tweets::deleteAll([]);
    }

}

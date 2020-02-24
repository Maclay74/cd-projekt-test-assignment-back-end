<?php

namespace app\components;


use yii\filters\auth\HttpBearerAuth;
use yii\filters\Cors;
use yii\rest\Controller;
use yii\web\Response;

class ApiController extends Controller {

    public $hostName;
    public $enableCsrfValidation = false;

    public function init() {
        parent::init();
        $this->hostName = \Yii::$app->request->getHostInfo();
    }

    public function behaviors() {
        return [
            'corsFilter' => [
                'class' => Cors::class,
            ],
            'authenticator' => [
                'class' => HttpBearerAuth::class,
            ]
        ];
    }

    public function beforeAction($action) {
        \Yii::$app->response->format = Response::FORMAT_JSON;
        return parent::beforeAction($action);
    }

}

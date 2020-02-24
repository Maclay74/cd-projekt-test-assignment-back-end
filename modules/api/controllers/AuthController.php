<?php

namespace app\modules\api\controllers;

use app\components\ApiController;
use app\models\LoginForm;
use yii\filters\auth\HttpBearerAuth;

class AuthController extends ApiController {

    public function behaviors() {
        return array_merge(parent::behaviors(), [
            'authenticator' => [
                'class' => HttpBearerAuth::class,
                'except' => ['log-in'],
            ],
        ]);
    }

    public function actionLogIn() {

        $requestBody = json_decode(file_get_contents('php://input'));
        $requestBody = get_object_vars($requestBody);

        $model = new LoginForm();
        $model->attributes = $requestBody;

        if (!$model->validate()) {
            \Yii::$app->response->setStatusCode(401);
            return ['errors' => $model->errors];
        }

        $token = $model->getUser()->generateAuthKey();

        return ['token' => $token];

    }
}

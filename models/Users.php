<?php

namespace app\models;

use Firebase\JWT\JWT;
use yii\db\ActiveRecord;
use yii\web\ForbiddenHttpException;
use yii\web\Request;

class Users extends ActiveRecord implements \yii\web\IdentityInterface {

    public static function tableName(){
        return 'users';
    }

    public function rules() {
        return [
            [['login', 'password'], 'required'],
        ];
    }

    public function attributeLabels() {
        return [
            'login' => 'Login',
            'password' => 'Password'
        ];
    }

    public static function findIdentity($id) {
        return static::findOne($id);
    }

    private static function getJWTSecret() {
        return \Yii::$app->components['request']['cookieValidationKey'];
    }

    public function generateAuthKey() {
        return  $this->getJWT();
    }

    public function getJWT() {

        $currentTime = time();
        $request     = \Yii::$app->request;
        $hostInfo    = '';

        if ($request instanceof Request) {
            $hostInfo = $request->hostInfo;
        }

        $token = [
            'iss' => $hostInfo,
            'aud' => $hostInfo,
            'iat' => $currentTime,
            'nbf' => $currentTime,
            'jti' => $this->getId()
        ];

        return JWT::encode($token, static::getJWTSecret(), 'HS256');
    }

    public function validatePassword($password) {
        return \Yii::$app->security->validatePassword($password, $this->password);
    }

    public static function findIdentityByAccessToken($token, $type = null) {

        try {
            $decodedToken = JWT::decode($token, static::getJWTSecret(), ['HS256']);
        } catch (\Exception $e) {
            throw new ForbiddenHttpException("Invalid token passed");
        }

        $decodedToken = (array) $decodedToken;

        if (!isset($decodedToken['jti'])) {
            throw new ForbiddenHttpException("Invalid token passed");
        }

        return static::findOne($decodedToken['jti']);
    }


    /**
     * @param $username
     * @return Users|ActiveRecord
     */
    public static function findByUsername($username) {
        return self::find()
            ->where(['login' => $username])
            ->one();
    }


    public function getId() {
        return $this->id;
    }

    public function getAuthKey() {
        return $this->getJWT();
    }

    public function validateAuthKey($authKey) {
        return $this->getJWT() === $authKey;
    }
}

<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 *
 * @property Users|null $user This property is read-only.
 *
 */
class LoginForm extends Model {

    public $login;
    public $password;
    private $user;


    /**
     * @return array the validation rules.
     */
    public function rules() {
        return [
            [['login', 'password'], 'required'],
            [['password'], 'validatePassword']
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params) {
        if (!$this->hasErrors()) {
            $user = $this->getUser();

            if (!$user)  {
                $this->addError('login', 'Incorrect login.');
                return false;
            }

            if (!$user->validatePassword($this->password)) {
                $this->addError('password', 'Incorrect password.');
            }
        }
    }

    /**
     * Finds user by [[login]]
     *
     * @return Users|null
     */
    public function getUser() {
        if (!$this->user) {
            $this->user = Users::findByUsername($this->login);
        }

        return $this->user;
    }
}

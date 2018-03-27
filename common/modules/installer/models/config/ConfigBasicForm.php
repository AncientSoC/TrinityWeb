<?php

namespace common\modules\installer\models\config;

use yii\base\Model;

/**
 * ConfigBasicForm holds basic application settings.
 */
class ConfigBasicForm extends Model
{
    public $name;
    public $email;
    public $robot_email;
    
    public $smtp_host;
    public $smtp_console_host;
    public $smtp_username;
    public $smtp_password;
    public $smtp_port;
    public $smtp_encrypt;

    /**
     * Declares the validation rules.
     */
    public function rules()
    {
        return [
            [['name', 'email', 'robot_email', 'smtp_host', 'smtp_console_host', 'smtp_username', 'smtp_password', 'smtp_port'], 'required'],
            [['email', 'robot_email'], 'email'],
            [['smtp_host','smtp_console_host','smtp_username','smtp_password','smtp_encrypt'], 'string'],
            ['smtp_port', 'integer']
        ];
    }

    /**
     * Declares customized attribute labels.
     * If not declared here, an attribute would have a label that is
     * the same as its name with the first letter in upper case.
     */
    public function attributeLabels()
    {
        return [
            'name'  => 'Name of your application',
            'email' => 'Administrator Email',
            'robot_email' => 'Robot Email',
            'smtp_host' => 'SMTP host',
            'smtp_console_host' => 'SMTP host for console app',
            'smtp_port' => 'SMTP port',
            'smtp_username' => 'SMTP username',
            'smtp_password' => 'SMTP password',
            'smtp_encrypt' => 'SMTP encrypt',
        ];
    }
}
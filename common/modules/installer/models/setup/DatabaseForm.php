<?php
namespace common\modules\installer\models\setup;

use Yii;
use yii\base\Model;

/**
 * DatabaseForm holds all required database settings.
 */
class DatabaseForm extends Model
{
    public $_name;
    
    public $host;
    public $port;
    public $database;
    public $login;
    public $password;
    public $table_prefix;
    
    public function __construct($config = array()) {
        parent::__construct($config);
        $this->setDefault();
    }
    
    protected function setDefault() {
        $this->host = 'localhost';
        $this->port = '3306';
        $this->database = 'main';
        $this->login = 'root';
    }
    
    public function scenarios() {
        return array_merge(
            parent::scenarios(),
            [
                'armory' => [['host','port','database','login','password','table_prefix']]
            ]
        );
    }
    
    public function rules()
    {
        return [
            [['host', 'port', 'database', 'login', 'password'], 'required'],
            [['host', 'database', 'login', 'password', 'table_prefix'],'string'],
            [['port'], 'integer']
        ];
    }

    public function attributeLabels()
    {
        return [
            'host' => 'Host',
            'port' => 'Port',
            'database' => 'Name of database',
            'login' => 'Username',
            'password' => 'Password',
            'table_perfix' => 'Table prefix'
        ];
    }
}
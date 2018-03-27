<?php
namespace common\modules\installer\models\setup;

use Yii;
use yii\base\Model;

/**
 * DatabaseForm holds all required database settings.
 */
class CharsDatabaseForm extends Model
{
    public $dbs = [];
    
    protected function setDefault() {
        $this->dbs = [
            [
                'host' => 'localhost',
                'port' => 3306,
                'db_name' => '',
                'login' => 'root',
                'password' => ''
            ]
        ];
    }
    
    public function rules()
    {
        return [
            [['dbs'], 'required'],
            [['dbs'], 'safe']
        ];
    }

    public function attributeLabels()
    {
        return [
            'dbs' => 'Базы данных'
        ];
    }
}
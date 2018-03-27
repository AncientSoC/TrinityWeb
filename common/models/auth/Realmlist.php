<?php

namespace common\models\auth;

use Yii;

/**
 * This is the model class for table "realmlist".
 *
 * @property integer $id
 * @property string $name
 * @property string $address
 * @property string $localAddress
 * @property string $localSubnetMask
 * @property integer $port
 * @property integer $icon
 * @property integer $flag
 * @property integer $timezone
 * @property integer $allowedSecurityLevel
 * @property double $population
 * @property integer $gamebuild
 */
class Realmlist extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'realmlist';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('auth');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['port', 'icon', 'flag', 'timezone', 'allowedSecurityLevel', 'gamebuild'], 'integer'],
            [['population'], 'number'],
            [['name'], 'string', 'max' => 32],
            [['address', 'localAddress', 'localSubnetMask'], 'string', 'max' => 255],
            [['name'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'address' => 'Address',
            'localAddress' => 'Local Address',
            'localSubnetMask' => 'Local Subnet Mask',
            'port' => 'Port',
            'icon' => 'Icon',
            'flag' => 'Flag',
            'timezone' => 'Timezone',
            'allowedSecurityLevel' => 'Allowed Security Level',
            'population' => 'Population',
            'gamebuild' => 'Gamebuild',
        ];
    }
    
}

<?php

namespace common\models\chars;

use Yii;

use common\core\models\characters\CoreModel;

class CharacterHomebind extends CoreModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'character_homebind';
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['guid'], 'required'],
            [['guid', 'mapId', 'zoneId'], 'integer'],
            [['posX', 'posY', 'posZ'], 'number'],
        ];
    }
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'guid' => 'Guid',
            'mapId' => 'Map ID',
            'zoneId' => 'Zone ID',
            'posX' => 'Pos X',
            'posY' => 'Pos Y',
            'posZ' => 'Pos Z',
        ];
    }
}

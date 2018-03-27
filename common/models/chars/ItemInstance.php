<?php

namespace common\models\chars;

use Yii;

use common\core\models\characters\CoreModel;

use common\models\armory\ArmoryItemTemplate;

/**
 * This is the model class for table "item_instance".
 *
 * @property integer $guid
 * @property integer $itemEntry
 * @property integer $owner_guid
 * @property integer $creatorGuid
 * @property integer $giftCreatorGuid
 * @property integer $count
 * @property integer $duration
 * @property string $charges
 * @property integer $flags
 * @property string $enchantments
 * @property integer $randomPropertyId
 * @property integer $durability
 * @property integer $playedTime
 * @property string $text
 */
class ItemInstance extends CoreModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'item_instance';
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['guid', 'enchantments'], 'required'],
            [['guid', 'itemEntry', 'owner_guid', 'creatorGuid', 'giftCreatorGuid', 'count', 'duration', 'flags', 'randomPropertyId', 'durability', 'playedTime'], 'integer'],
            [['charges', 'enchantments', 'text'], 'string'],
        ];
    }
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'guid' => 'Guid',
            'itemEntry' => 'Item Entry',
            'owner_guid' => 'Owner Guid',
            'creatorGuid' => 'Creator Guid',
            'giftCreatorGuid' => 'Gift Creator Guid',
            'count' => 'Count',
            'duration' => 'Duration',
            'charges' => 'Charges',
            'flags' => 'Flags',
            'enchantments' => 'Enchantments',
            'randomPropertyId' => 'Random Property ID',
            'durability' => 'Durability',
            'playedTime' => 'Played Time',
            'text' => 'Text',
        ];
    }
    /**
    * Связь для получения объекта содержащего данные о вещи из БД Armory
    * @return \yii\db\ActiveQuery
    */
    public function getRelationArmoryItem() {
        return $this->hasOne(ArmoryItemTemplate::className(),['entry' => 'itemEntry'])->select(['displayid','entry']);
    }
    
}

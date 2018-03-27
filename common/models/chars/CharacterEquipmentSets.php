<?php

namespace common\models\chars;

use Yii;

use common\core\models\characters\CoreModel;

/**
 * This is the model class for table "character_equipmentsets".
 *
 * @property integer $guid
 * @property string $setguid
 * @property integer $setindex
 * @property string $name
 * @property string $iconname
 * @property integer $ignore_mask
 * @property integer $item0
 * @property integer $item1
 * @property integer $item2
 * @property integer $item3
 * @property integer $item4
 * @property integer $item5
 * @property integer $item6
 * @property integer $item7
 * @property integer $item8
 * @property integer $item9
 * @property integer $item10
 * @property integer $item11
 * @property integer $item12
 * @property integer $item13
 * @property integer $item14
 * @property integer $item15
 * @property integer $item16
 * @property integer $item17
 * @property integer $item18
 */
class CharacterEquipmentSets extends CoreModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'character_equipmentsets';
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['guid', 'setindex', 'ignore_mask', 'item0', 'item1', 'item2', 'item3', 'item4', 'item5', 'item6', 'item7', 'item8', 'item9', 'item10', 'item11', 'item12', 'item13', 'item14', 'item15', 'item16', 'item17', 'item18'], 'integer'],
            [['name', 'iconname'], 'required'],
            [['name'], 'string', 'max' => 31],
            [['iconname'], 'string', 'max' => 100],
        ];
    }
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'guid' => 'Guid',
            'setguid' => 'Setguid',
            'setindex' => 'Setindex',
            'name' => 'Name',
            'iconname' => 'Iconname',
            'ignore_mask' => 'Ignore Mask',
            'item0' => 'Item0',
            'item1' => 'Item1',
            'item2' => 'Item2',
            'item3' => 'Item3',
            'item4' => 'Item4',
            'item5' => 'Item5',
            'item6' => 'Item6',
            'item7' => 'Item7',
            'item8' => 'Item8',
            'item9' => 'Item9',
            'item10' => 'Item10',
            'item11' => 'Item11',
            'item12' => 'Item12',
            'item13' => 'Item13',
            'item14' => 'Item14',
            'item15' => 'Item15',
            'item16' => 'Item16',
            'item17' => 'Item17',
            'item18' => 'Item18',
        ];
    }
}

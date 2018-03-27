<?php

namespace common\models\chars;

use Yii;

use common\core\models\characters\CoreModel;

/**
 * This is the model class for table "guild".
 *
 * @property integer $guildid
 * @property string $name
 * @property integer $leaderguid
 * @property integer $EmblemStyle
 * @property integer $EmblemColor
 * @property integer $BorderStyle
 * @property integer $BorderColor
 * @property integer $BackgroundColor
 * @property string $info
 * @property string $motd
 * @property integer $createdate
 * @property string $BankMoney
 */
class Guild extends CoreModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'guild';
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['guildid'], 'required'],
            [['guildid', 'leaderguid', 'EmblemStyle', 'EmblemColor', 'BorderStyle', 'BorderColor', 'BackgroundColor', 'createdate', 'BankMoney'], 'integer'],
            [['name'], 'string', 'max' => 24],
            [['info'], 'string', 'max' => 500],
            [['motd'], 'string', 'max' => 128],
        ];
    }
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'guildid' => 'Guildid',
            'name' => 'Name',
            'leaderguid' => 'Leaderguid',
            'EmblemStyle' => 'Emblem Style',
            'EmblemColor' => 'Emblem Color',
            'BorderStyle' => 'Border Style',
            'BorderColor' => 'Border Color',
            'BackgroundColor' => 'Background Color',
            'info' => 'Info',
            'motd' => 'Motd',
            'createdate' => 'Createdate',
            'BankMoney' => 'Bank Money',
        ];
    }
}

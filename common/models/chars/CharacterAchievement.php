<?php

namespace common\models\chars;

use Yii;

use common\core\models\characters\CoreModel;

use common\models\armory\ArmoryAchievement;

/**
 * This is the model class for table "character_achievement".
 *
 * @property integer $guid
 * @property integer $achievement
 * @property integer $date
 */
class CharacterAchievement extends CoreModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'character_achievement';
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['guid', 'achievement'], 'required'],
            [['guid', 'achievement', 'date'], 'integer'],
        ];
    }
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'guid' => 'Guid',
            'achievement' => 'Achievement',
            'date' => 'Date',
        ];
    }
    /**
    * Связь для получения объекта содержащего данные о участниках команды
    * @return \yii\db\ActiveQuery
    */
    public function getRelationAchievement() {
        return $this->hasOne(ArmoryAchievement::className(), ['id' => 'achievement']);
    }

}

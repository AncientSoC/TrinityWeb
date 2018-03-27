<?php

namespace common\models\chars;

use Yii;

use common\core\models\characters\CoreModel;

/**
 * This is the model class for table "arena_team_member".
 *
 * @property integer $arenaTeamId
 * @property integer $guid
 * @property integer $weekGames
 * @property integer $weekWins
 * @property integer $seasonGames
 * @property integer $seasonWins
 * @property integer $personalRating
 */
class ArenaTeamMember extends CoreModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'arena_team_member';
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['arenaTeamId', 'guid'], 'required'],
            [['arenaTeamId', 'guid', 'weekGames', 'weekWins', 'seasonGames', 'seasonWins', 'personalRating'], 'integer'],
        ];
    }
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'arenaTeamId' => 'Arena Team ID',
            'guid' => 'Guid',
            'weekGames' => Yii::t('common', 'Недельных игр'),
            'weekWins' => Yii::t('common', 'Недельных побед'),
            'seasonGames' => Yii::t('common', 'Игр в сезоне'),
            'seasonWins' => Yii::t('common', 'Побед в сезоне'),
            'personalRating' => Yii::t('common', 'личный рейтинг'),
        ];
    }
    /**
    * Связь для получения объекта содержащего данные о персонаже (участнике команды)
    * @return \yii\db\ActiveQuery
    */
    public function getRelationCharacter() {
        return $this->hasOne(Characters::className(), ['guid' => 'guid']);
    }
    /**
    * Связь для получения объекта содержащего данные о команде
    * @return \yii\db\ActiveQuery
    */
    public function getRelationTeam() {
        return $this->hasOne(ArenaTeam::className(),['arenaTeamId' => 'arenaTeamId']);
    }
    
}

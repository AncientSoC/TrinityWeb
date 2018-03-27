<?php

namespace common\models\chars;

use Yii;

use common\core\models\characters\CoreModel;

/**
 * This is the model class for table "character_stats".
 *
 * @property integer $guid
 * @property integer $maxhealth
 * @property integer $maxpower1
 * @property integer $maxpower2
 * @property integer $maxpower3
 * @property integer $maxpower4
 * @property integer $maxpower5
 * @property integer $maxpower6
 * @property integer $maxpower7
 * @property integer $strength
 * @property integer $agility
 * @property integer $stamina
 * @property integer $intellect
 * @property integer $spirit
 * @property integer $armor
 * @property integer $resHoly
 * @property integer $resFire
 * @property integer $resNature
 * @property integer $resFrost
 * @property integer $resShadow
 * @property integer $resArcane
 * @property double $blockPct
 * @property double $dodgePct
 * @property double $parryPct
 * @property double $critPct
 * @property double $rangedCritPct
 * @property double $spellCritPct
 * @property integer $attackPower
 * @property integer $rangedAttackPower
 * @property integer $spellPower
 * @property integer $resilience
 */
class CharacterStats extends CoreModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'character_stats';
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['guid'], 'required'],
            [['guid', 'maxhealth', 'maxpower1', 'maxpower2', 'maxpower3', 'maxpower4', 'maxpower5', 'maxpower6', 'maxpower7', 'strength', 'agility', 'stamina', 'intellect', 'spirit', 'armor', 'resHoly', 'resFire', 'resNature', 'resFrost', 'resShadow', 'resArcane', 'attackPower', 'rangedAttackPower', 'spellPower', 'resilience', 'achievementPoints'], 'integer'],
            [['blockPct', 'dodgePct', 'parryPct', 'critPct', 'rangedCritPct', 'spellCritPct'], 'number'],
        ];
    }
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'guid' => 'Guid',
            'maxhealth' => 'Maxhealth',
            'maxpower1' => 'Maxpower1',
            'maxpower2' => 'Maxpower2',
            'maxpower3' => 'Maxpower3',
            'maxpower4' => 'Maxpower4',
            'maxpower5' => 'Maxpower5',
            'maxpower6' => 'Maxpower6',
            'maxpower7' => 'Maxpower7',
            'strength' => 'Strength',
            'agility' => 'Agility',
            'stamina' => 'Stamina',
            'intellect' => 'Intellect',
            'spirit' => 'Spirit',
            'armor' => 'Armor',
            'resHoly' => 'Res Holy',
            'resFire' => 'Res Fire',
            'resNature' => 'Res Nature',
            'resFrost' => 'Res Frost',
            'resShadow' => 'Res Shadow',
            'resArcane' => 'Res Arcane',
            'blockPct' => 'Block Pct',
            'dodgePct' => 'Dodge Pct',
            'parryPct' => 'Parry Pct',
            'critPct' => 'Crit Pct',
            'rangedCritPct' => 'Ranged Crit Pct',
            'spellCritPct' => 'Spell Crit Pct',
            'attackPower' => 'Attack Power',
            'rangedAttackPower' => 'Ranged Attack Power',
            'spellPower' => 'Spell Power',
            'resilience' => 'Resilience',
            'achievementPoints' => 'Achievement Points',
        ];
    }
}

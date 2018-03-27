<?php

namespace common\models\armory;

use Yii;

/**
 * This is the model class for table "armory_rating".
 *
 * @property integer $level
 * @property double $MC_Warrior
 * @property double $MC_Paladin
 * @property double $MC_Hunter
 * @property double $MC_Rogue
 * @property double $MC_Priest
 * @property double $MC_DeathKnight
 * @property double $MC_Shaman
 * @property double $MC_Mage
 * @property double $MC_Warlock
 * @property double $MC_10
 * @property double $MC_Druid
 * @property double $SC_Warrior
 * @property double $SC_Paladin
 * @property double $SC_Hunter
 * @property double $SC_Rogue
 * @property double $SC_Priest
 * @property double $SC_DeathKnight
 * @property double $SC_Shaman
 * @property double $SC_Mage
 * @property double $SC_Warlock
 * @property double $SC_10
 * @property double $SC_Druid
 * @property double $HR_Warrior
 * @property double $HR_Paladin
 * @property double $HR_Hunter
 * @property double $HR_Rogue
 * @property double $HR_Priest
 * @property double $HR_DeathKnight
 * @property double $HR_Shaman
 * @property double $HR_Mage
 * @property double $HR_Warlock
 * @property double $HR_10
 * @property double $HR_Druid
 * @property double $MR_Warrior
 * @property double $MR_Paladin
 * @property double $MR_Hunter
 * @property double $MR_Rogue
 * @property double $MR_Priest
 * @property double $MR_DeathKnight
 * @property double $MR_Shaman
 * @property double $MR_Mage
 * @property double $MR_Warlock
 * @property double $MR_10
 * @property double $MR_Druid
 * @property double $CR_WEAPON_SKILL
 * @property double $CR_DEFENSE_SKILL
 * @property double $CR_DODGE
 * @property double $CR_PARRY
 * @property double $CR_BLOCK
 * @property double $CR_HIT_MELEE
 * @property double $CR_HIT_RANGED
 * @property double $CR_HIT_SPELL
 * @property double $CR_CRIT_MELEE
 * @property double $CR_CRIT_RANGED
 * @property double $CR_CRIT_SPELL
 * @property double $CR_HIT_TAKEN_MELEE
 * @property double $CR_HIT_TAKEN_RANGED
 * @property double $CR_HIT_TAKEN_SPELL
 * @property double $CR_CRIT_TAKEN_MELEE
 * @property double $CR_CRIT_TAKEN_RANGED
 * @property double $CR_CRIT_TAKEN_SPELL
 * @property double $CR_HASTE_MELEE
 * @property double $CR_HASTE_RANGED
 * @property double $CR_HASTE_SPELL
 * @property double $CR_WEAPON_SKILL_MAINHAND
 * @property double $CR_WEAPON_SKILL_OFFHAND
 * @property double $CR_WEAPON_SKILL_RANGED
 * @property double $CR_EXPERTISE
 * @property double $CR_ARMOR_PENETRATION
 */
class ArmoryRating extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'armory_rating';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('armory_db');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['level', 'CR_EXPERTISE', 'CR_ARMOR_PENETRATION'], 'required'],
            [['level'], 'integer'],
            [['MC_Warrior', 'MC_Paladin', 'MC_Hunter', 'MC_Rogue', 'MC_Priest', 'MC_DeathKnight', 'MC_Shaman', 'MC_Mage', 'MC_Warlock', 'MC_10', 'MC_Druid', 'SC_Warrior', 'SC_Paladin', 'SC_Hunter', 'SC_Rogue', 'SC_Priest', 'SC_DeathKnight', 'SC_Shaman', 'SC_Mage', 'SC_Warlock', 'SC_10', 'SC_Druid', 'HR_Warrior', 'HR_Paladin', 'HR_Hunter', 'HR_Rogue', 'HR_Priest', 'HR_DeathKnight', 'HR_Shaman', 'HR_Mage', 'HR_Warlock', 'HR_10', 'HR_Druid', 'MR_Warrior', 'MR_Paladin', 'MR_Hunter', 'MR_Rogue', 'MR_Priest', 'MR_DeathKnight', 'MR_Shaman', 'MR_Mage', 'MR_Warlock', 'MR_10', 'MR_Druid', 'CR_WEAPON_SKILL', 'CR_DEFENSE_SKILL', 'CR_DODGE', 'CR_PARRY', 'CR_BLOCK', 'CR_HIT_MELEE', 'CR_HIT_RANGED', 'CR_HIT_SPELL', 'CR_CRIT_MELEE', 'CR_CRIT_RANGED', 'CR_CRIT_SPELL', 'CR_HIT_TAKEN_MELEE', 'CR_HIT_TAKEN_RANGED', 'CR_HIT_TAKEN_SPELL', 'CR_CRIT_TAKEN_MELEE', 'CR_CRIT_TAKEN_RANGED', 'CR_CRIT_TAKEN_SPELL', 'CR_HASTE_MELEE', 'CR_HASTE_RANGED', 'CR_HASTE_SPELL', 'CR_WEAPON_SKILL_MAINHAND', 'CR_WEAPON_SKILL_OFFHAND', 'CR_WEAPON_SKILL_RANGED', 'CR_EXPERTISE', 'CR_ARMOR_PENETRATION'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'level' => 'Level',
            'MC_Warrior' => 'Mc  Warrior',
            'MC_Paladin' => 'Mc  Paladin',
            'MC_Hunter' => 'Mc  Hunter',
            'MC_Rogue' => 'Mc  Rogue',
            'MC_Priest' => 'Mc  Priest',
            'MC_DeathKnight' => 'Mc  Death Knight',
            'MC_Shaman' => 'Mc  Shaman',
            'MC_Mage' => 'Mc  Mage',
            'MC_Warlock' => 'Mc  Warlock',
            'MC_10' => 'Mc 10',
            'MC_Druid' => 'Mc  Druid',
            'SC_Warrior' => 'Sc  Warrior',
            'SC_Paladin' => 'Sc  Paladin',
            'SC_Hunter' => 'Sc  Hunter',
            'SC_Rogue' => 'Sc  Rogue',
            'SC_Priest' => 'Sc  Priest',
            'SC_DeathKnight' => 'Sc  Death Knight',
            'SC_Shaman' => 'Sc  Shaman',
            'SC_Mage' => 'Sc  Mage',
            'SC_Warlock' => 'Sc  Warlock',
            'SC_10' => 'Sc 10',
            'SC_Druid' => 'Sc  Druid',
            'HR_Warrior' => 'Hr  Warrior',
            'HR_Paladin' => 'Hr  Paladin',
            'HR_Hunter' => 'Hr  Hunter',
            'HR_Rogue' => 'Hr  Rogue',
            'HR_Priest' => 'Hr  Priest',
            'HR_DeathKnight' => 'Hr  Death Knight',
            'HR_Shaman' => 'Hr  Shaman',
            'HR_Mage' => 'Hr  Mage',
            'HR_Warlock' => 'Hr  Warlock',
            'HR_10' => 'Hr 10',
            'HR_Druid' => 'Hr  Druid',
            'MR_Warrior' => 'Mr  Warrior',
            'MR_Paladin' => 'Mr  Paladin',
            'MR_Hunter' => 'Mr  Hunter',
            'MR_Rogue' => 'Mr  Rogue',
            'MR_Priest' => 'Mr  Priest',
            'MR_DeathKnight' => 'Mr  Death Knight',
            'MR_Shaman' => 'Mr  Shaman',
            'MR_Mage' => 'Mr  Mage',
            'MR_Warlock' => 'Mr  Warlock',
            'MR_10' => 'Mr 10',
            'MR_Druid' => 'Mr  Druid',
            'CR_WEAPON_SKILL' => 'Cr  Weapon  Skill',
            'CR_DEFENSE_SKILL' => 'Cr  Defense  Skill',
            'CR_DODGE' => 'Cr  Dodge',
            'CR_PARRY' => 'Cr  Parry',
            'CR_BLOCK' => 'Cr  Block',
            'CR_HIT_MELEE' => 'Cr  Hit  Melee',
            'CR_HIT_RANGED' => 'Cr  Hit  Ranged',
            'CR_HIT_SPELL' => 'Cr  Hit  Spell',
            'CR_CRIT_MELEE' => 'Cr  Crit  Melee',
            'CR_CRIT_RANGED' => 'Cr  Crit  Ranged',
            'CR_CRIT_SPELL' => 'Cr  Crit  Spell',
            'CR_HIT_TAKEN_MELEE' => 'Cr  Hit  Taken  Melee',
            'CR_HIT_TAKEN_RANGED' => 'Cr  Hit  Taken  Ranged',
            'CR_HIT_TAKEN_SPELL' => 'Cr  Hit  Taken  Spell',
            'CR_CRIT_TAKEN_MELEE' => 'Cr  Crit  Taken  Melee',
            'CR_CRIT_TAKEN_RANGED' => 'Cr  Crit  Taken  Ranged',
            'CR_CRIT_TAKEN_SPELL' => 'Cr  Crit  Taken  Spell',
            'CR_HASTE_MELEE' => 'Cr  Haste  Melee',
            'CR_HASTE_RANGED' => 'Cr  Haste  Ranged',
            'CR_HASTE_SPELL' => 'Cr  Haste  Spell',
            'CR_WEAPON_SKILL_MAINHAND' => 'Cr  Weapon  Skill  Mainhand',
            'CR_WEAPON_SKILL_OFFHAND' => 'Cr  Weapon  Skill  Offhand',
            'CR_WEAPON_SKILL_RANGED' => 'Cr  Weapon  Skill  Ranged',
            'CR_EXPERTISE' => 'Cr  Expertise',
            'CR_ARMOR_PENETRATION' => 'Cr  Armor  Penetration',
        ];
    }
}
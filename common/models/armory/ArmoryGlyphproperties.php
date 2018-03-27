<?php

namespace common\models\armory;

use Yii;

/**
 * This is the model class for table "armory_glyphproperties".
 *
 * @property integer $id
 * @property integer $spell
 * @property integer $type
 * @property string $name_de_de
 * @property string $name_zh_cn
 * @property string $name_en_gb
 * @property string $name_ru_ru
 * @property string $description_de_de
 * @property string $description_zh_cn
 * @property string $description_en_gb
 * @property string $description_ru_ru
 */
class ArmoryGlyphproperties extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'armory_glyphproperties';
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
            [['id', 'spell', 'type', 'name_de_de', 'name_zh_cn', 'name_en_gb', 'name_ru_ru', 'description_de_de', 'description_zh_cn', 'description_en_gb', 'description_ru_ru'], 'required'],
            [['id', 'spell', 'type'], 'integer'],
            [['description_de_de', 'description_zh_cn', 'description_en_gb', 'description_ru_ru'], 'string'],
            [['name_de_de', 'name_zh_cn', 'name_en_gb', 'name_ru_ru'], 'string', 'max' => 255],
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'spell' => 'Spell',
            'type' => 'Type',
            'name_de_de' => 'Name De De',
            'name_zh_cn' => 'Name Zh Cn',
            'name_en_gb' => 'Name En Gb',
            'name_ru_ru' => 'Name Ru Ru',
            'description_de_de' => 'Description De De',
            'description_zh_cn' => 'Description Zh Cn',
            'description_en_gb' => 'Description En Gb',
            'description_ru_ru' => 'Description Ru Ru',
        ];
    }

    public function getRelationSpellIcon() {
        return $this->hasOne(ArmorySpellIcon::className(), ['id' => 'spell']);
    }

}
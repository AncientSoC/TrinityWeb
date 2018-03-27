<?php

namespace common\models\armory;

use Yii;

/**
 * This is the model class for table "armory_titles".
 *
 * @property integer $id
 * @property string $title_M_de_de
 * @property string $title_M_zh_cn
 * @property string $title_M_en_gb
 * @property string $title_M_es_es
 * @property string $title_M_fr_fr
 * @property string $title_M_ru_ru
 * @property string $title_F_de_de
 * @property string $title_F_zh_cn
 * @property string $title_F_en_gb
 * @property string $title_F_es_es
 * @property string $title_F_fr_fr
 * @property string $title_F_ru_ru
 * @property string $place
 */
class ArmoryTitles extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'armory_titles';
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
            [['id', 'title_M_de_de', 'title_M_zh_cn', 'title_M_en_gb', 'title_M_es_es', 'title_M_fr_fr', 'title_M_ru_ru', 'title_F_de_de', 'title_F_zh_cn', 'title_F_en_gb', 'title_F_es_es', 'title_F_fr_fr', 'title_F_ru_ru', 'place'], 'required'],
            [['id'], 'integer'],
            [['title_M_de_de', 'title_M_zh_cn', 'title_M_en_gb', 'title_M_es_es', 'title_M_fr_fr', 'title_M_ru_ru', 'title_F_de_de', 'title_F_zh_cn', 'title_F_en_gb', 'title_F_es_es', 'title_F_fr_fr', 'title_F_ru_ru'], 'string'],
            [['place'], 'string', 'max' => 6],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title_M_de_de' => 'Title  M De De',
            'title_M_zh_cn' => 'Title  M Zh Cn',
            'title_M_en_gb' => 'Title  M En Gb',
            'title_M_es_es' => 'Title  M Es Es',
            'title_M_fr_fr' => 'Title  M Fr Fr',
            'title_M_ru_ru' => 'Title  M Ru Ru',
            'title_F_de_de' => 'Title  F De De',
            'title_F_zh_cn' => 'Title  F Zh Cn',
            'title_F_en_gb' => 'Title  F En Gb',
            'title_F_es_es' => 'Title  F Es Es',
            'title_F_fr_fr' => 'Title  F Fr Fr',
            'title_F_ru_ru' => 'Title  F Ru Ru',
            'place' => 'Place',
        ];
    }
}
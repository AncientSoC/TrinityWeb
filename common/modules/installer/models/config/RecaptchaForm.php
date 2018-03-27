<?php
namespace common\modules\installer\models\config;

use yii\base\Model;

/**
 * Class RecaptchaForm
 * Holds the recaptcha settings
 *
 * @package common\modules\installer\models\config
 */
class RecaptchaForm extends Model
{
	public $secret;
	public $siteKey;

	public function rules()
	{
            return [
                [['siteKey', 'secret'], 'string'],
            ];
	}

	public function attributeLabels()
	{
            return [
                'siteKey'   => 'Site Key (optional)',
                'secret'    => 'Secret (optional)',
            ];
	}
}

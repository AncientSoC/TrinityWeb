<?php

namespace common\modules\i18n\commands;

use common\modules\i18n\services\Optimizer;
use common\modules\i18n\services\Scanner;
use yii\console\Controller;
use yii\helpers\Console;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;

use common\modules\i18n\models\Language;
use common\modules\i18n\models\LanguageSource;
use common\modules\i18n\models\LanguageTranslate;

/**
 * Command for scanning and optimizing project translations
 *
 * @author Tobias Munk <schmunk@usrbin.de>
 *
 * @since 1.2.8
 */
class TranslatemanagerController extends Controller
{
    /**
     * @inheritdoc
     */
    public $defaultAction = 'help';

    /**
     * Display this help.
     */
    public function actionHelp()
    {
        $this->run('/help', [$this->id]);
    }

    /**
     * Detecting new language elements.
     */
    public function actionScan()
    {
        $this->stdout("Scanning translations...\n", Console::BOLD);
        $scanner = new Scanner();

        $items = $scanner->run();
        $this->stdout("{$items} new item(s) inserted into database.\n");
    }

    /**
     * Removing unused language elements.
     */
    public function actionOptimize()
    {
        $this->stdout("Optimizing translations...\n", Console::BOLD);
        $optimizer = new Optimizer();
        $items = $optimizer->run();
        $this->stdout("{$items} removed from database.\n");
    }
    
    /**
     * Base language elements.
     */
    public function actionBase()
    {
        $this->stdout("Import translations...\n", Console::BOLD);
        
        $importFileContent = file_get_contents(\Yii::getAlias('@console') . '/dumps/translations.json');

        $data = Json::decode($importFileContent);
        
        $result = [
            'languages' => ['new' => 0, 'updated' => 0],
            'languageSources' => ['new' => 0, 'updated' => 0],
            'languageTranslations' => ['new' => 0, 'updated' => 0],
        ];

        /** @var Language[] $languages */
        $languages = Language::find()->indexBy('language_id')->all();

        foreach ($data['languages'] as $importedLanguage) {
            if (isset($languages[$importedLanguage['language_id']])) {
                $language = $languages[$importedLanguage['language_id']];
            } else {
                $language = new Language();
            }

            //cast integers
            $importedLanguage['status'] = (int) $importedLanguage['status'];

            $language->attributes = $importedLanguage;
            if (count($language->getDirtyAttributes())) {
                $saveType = $language->isNewRecord ? 'new' : 'updated';
                if ($language->save()) {
                    ++$result['languages'][$saveType];
                } else {
                    $this->throwInvalidModelException($language);
                }
            }
        }

        /** @var LanguageSource[] $languageSources */
        $languageSources = LanguageSource::find()->indexBy('id')->all();

        /** @var LanguageTranslate[] $languageTranslations */
        $languageTranslations = LanguageTranslate::find()->all();

        /*
         *  Create 2 dimensional array for current and imported translation, first index by LanguageSource->id
         *  and than indexed by LanguageTranslate->language.
         *  E.g.: [
         *      id => [
         *          language => LanguageTranslate (for $languageTranslations) / Array (for $importedLanguageTranslations)
         *          ...
         *      ]
         *      ...
         * ]
         */
        $languageTranslations = ArrayHelper::map($languageTranslations, 'language', function ($languageTranslation) {
            return $languageTranslation;
        }, 'id');
        $importedLanguageTranslations = ArrayHelper::map($data['languageTranslations'], 'language', function ($languageTranslation) {
            return $languageTranslation;
        }, 'id');

        foreach ($data['languageSources'] as $importedLanguageSource) {
            $languageSource = null;

            //check if id exist and if category and messages are matching
            if (isset($languageSources[$importedLanguageSource['id']]) &&
                ($languageSources[$importedLanguageSource['id']]->category == $importedLanguageSource['category']) &&
                ($languageSources[$importedLanguageSource['id']]->message == $importedLanguageSource['message'])
            ) {
                $languageSource = $languageSources[$importedLanguageSource['id']];
            }

            if (is_null($languageSource)) {
                //no match by id, search by message
                foreach ($languageSources as $languageSourceSearch) {
                    if (($languageSourceSearch->category == $importedLanguageSource['category']) &&
                        ($languageSourceSearch->message == $importedLanguageSource['message'])
                    ) {
                        $languageSource = $languageSourceSearch;
                        break;
                    }
                }
            }

            if (is_null($languageSource)) {
                //still no match, create new
                $languageSource = new LanguageSource([
                    'category' => $importedLanguageSource['category'],
                    'message' => $importedLanguageSource['message'],
                ]);

                if ($languageSource->save()) {
                    ++$result['languageSources']['new'];
                } else {
                    $this->throwInvalidModelException($languageSource);
                }
            }

            //do we have translations for the current source?
            if (isset($importedLanguageTranslations[$importedLanguageSource['id']])) {
                //loop through the translations for the current source
                foreach ($importedLanguageTranslations[$importedLanguageSource['id']] as $importedLanguageTranslation) {
                    $languageTranslate = null;

                    //is there already a translation for this souce
                    if (isset($languageTranslations[$languageSource->id]) &&
                        isset($languageTranslations[$languageSource->id][$importedLanguageTranslation['language']])
                    ) {
                        $languageTranslate = $languageTranslations[$languageSource->id][$importedLanguageTranslation['language']];
                    }

                    //no translation found, create a new one
                    if (is_null($languageTranslate)) {
                        $languageTranslate = new LanguageTranslate();
                    }

                    $languageTranslate->attributes = $importedLanguageTranslation;

                    //overwrite the id because the $languageSource->id might be different from the $importedLanguageTranslation['id']
                    $languageTranslate->id = $languageSource->id;

                    if (count($languageTranslate->getDirtyAttributes())) {
                        $saveType = $languageTranslate->isNewRecord ? 'new' : 'updated';
                        if ($languageTranslate->save()) {
                            ++$result['languageTranslations'][$saveType];
                        } else {
                            $this->throwInvalidModelException($languageTranslate);
                        }
                    }
                }
            }
        }
        
        \Yii::$app->cache->flush();
        
        print_r($result);
        $this->stdout("Done!\n");
    }
}

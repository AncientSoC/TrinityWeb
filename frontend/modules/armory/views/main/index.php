<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\data\Pagination;
use yii\widgets\LinkPager;
use yii\bootstrap\ActiveForm;
use common\components\helpers\Configuration;
use frontend\modules\armory\models\SearchForm;

if($counter) {
    $pages = new Pagination(['totalCount' => $counter, 'defaultPageSize' => SearchForm::getPageSize()]);
}

?>
<?php $form = ActiveForm::begin([
        'id' => 'armory-form',
        'method' => 'get',
        'action' => ['/armory']
    ]); ?>
    <div class="row justify-content-center">
        <div class="col-sm-4 col-md-3 col-xl-2">
            <?php echo $form->field($searchModel, 'server')->dropDownList($searchModel->getServers(),[
                    'prompt' => Yii::t('cp','Выберите сервер'),
                    'name' => 'server',
                ])->label(false) ?>
        </div>
        <div class="col-sm-4 col-md-4 col-xl-3">
            <?php echo $form->field($searchModel, 'query')->label(false) ?>
        </div>
        <div class="col-4 col-sm-3 col-md-2 col-xl-2">
            <div class="form-group text-center-sm text-center-xs">
                <?php echo Html::submitButton(Yii::t('common', 'Поиск'), ['class' => 'btn btn-primary w-100']) ?>
            </div>
        </div>
    </div>
    <?php
    if($searchResult) {
        foreach($searchResult as $character) {
    ?>
        <div class="row justify-content-center">
            <div class="col-6 col-sm-4 col-md-4 flat character_armory_find_result">
                <?=Yii::$app->AppHelper->buildTagRaceImage($character['race'],$character['gender'])?>
                <?=Yii::$app->AppHelper->buildTagClassImage($character['class'])?>
                <?php
                    echo Html::a($character['name'],
                        [
                            'character/index','server' => Yii::$app->CharactersDbHelper->getServerName(),
                            'character' => $character['name']
                        ],['target' => '_blank']
                    );
                ?>
            </div>
        </div>
        <?php
        }?>
        <div class="row justify-content-center">
            <?php
                echo LinkPager::widget([
                    'pagination' => $pages,
                ]);
            ?>
        </div>
    <?php
    }
    ?>
<?php ActiveForm::end(); ?>
<?php
use yii\helpers\Html;
use common\components\helpers\Configuration;
?>
<div id="ladder-team-container">
    <table class="flat table table-dark">
        <thead class="ladder-team-header">
            <tr>
                <th scope="col">
                    <?=Yii::t('ladder','Участник')?>
                </th>
                <th scope="col" class="d-none d-lg-table-cell">
                    <?=Yii::t('ladder','Расса/Класс')?>
                </th>
                <th scope="col">
                    <?=Yii::t('ladder','Поб.')?>
                </th>
                <th scope="col">
                    <?=Yii::t('ladder','Пор.')?>
                </th>
                <th scope="col">
                    <?=Yii::t('ladder','Рейтинг')?>
                </th>
                <th scope="col" class="d-none d-sm-table-cell">
                    <?=Yii::t('ladder','ММР')?>
                </th>
            </tr>
        </thead>
        <tbody class="ladder-team-members">
            <?php
            foreach($data['relationMembers'] as $item) {
            ?>
            <tr class="ladder-team-member">
                <td>
                    <?php
                    if(Yii::$app->keyStorage->get(Configuration::MODULE_ARMORY) ===  Configuration::ENABLED) {
                        echo Html::a($item['relationCharacter']['name'],[
                            '/armory/character/index',
                            'server' => Yii::$app->CharactersDbHelper->getServerNameById(Yii::$app->CharactersDbHelper->getServerFromGet()),
                            'character' => $item['relationCharacter']['name']
                        ]);
                    } else {
                        echo ("<span>" . $item['relationCharacter']['name'] . "</span>");
                    }
                    ?>
                </td>
                <td class="d-none d-lg-table-cell">
                    <?php
                        echo Yii::$app->AppHelper->buildTagRaceImage($item['relationCharacter']['race'],$item['relationCharacter']['gender']);
                        echo Yii::$app->AppHelper->buildTagClassImage($item['relationCharacter']['class']);
                    ?>
                </td>
                <td>
                    <span><?=$item['seasonWins']?></span>
                </td>
                <td>
                    <span><?=($item['seasonGames'] - $item['seasonWins'])?></span>
                </td>
                <td>
                    <?=$item['personalRating']?>
                </td>
                <td class="d-none d-sm-table-cell">
                    <?php
                    $mmr = 1500;
                    if($item['relationCharacter']) {
                        $character = $item['relationCharacter'];
                        if($character['relationArenaStats']) {
                            foreach($character['relationArenaStats'] as $mmr_info) {
                                //type 2v2 to slot = 0 for 2v2
                                if($data['type'] === 2 && $mmr_info['slot'] === 0) {
                                    $mmr = $mmr_info['matchMakerRating'];
                                //type 3v3 to slot = 1 for 3v3
                                } elseif($data['type'] === 3 && $mmr_info['slot'] === 1) {
                                    $mmr = $mmr_info['matchMakerRating'];
                                //type 5v5 to slot = 2 for 5v5
                                } elseif($data['type'] === 5 && $mmr_info['slot'] === 2) {
                                    $mmr = $mmr_info['matchMakerRating'];
                                }
                            }
                        }
                    }
                    echo $mmr;
                    ?>
                </td>
            </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
</div>
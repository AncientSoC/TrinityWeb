<div class="card widget" id="widget-status_servers">
    <div class="card-header">
        <p>
        <?=Yii::t('frontend','Всего: {count}', [
            'count' => $shared_online,
        ])?>
        </p>
        Realmlist: <?=Yii::$app->keyStorage->get('frontend.realmlist')?>
    </div>
    <div class="card-body">
        <?php
        foreach($status_list as $server_name => $status) {
        ?>
            <div class="card">
                <div class="card-header"><?=$server_name?>: 
                <?php
                if($status['status'] == Yii::$app->AppHelper::$ONLINE) {
                    echo count($status['online_list']);
                } else {
                    echo Yii::t('frontend','выключен');
                }
                ?>
                </div>
            </div>      
        <?php
        }
        ?>
    </div>
</div>
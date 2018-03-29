<div class="card widget" id="widget-status_servers">
    <div class="card-header text-center pt-2 pb-1">
        <h5>
            <?=Yii::t('frontend','Общий онлайн: {count}', [
                'count' => $shared_online,
            ])?>
        </h5>
    </div>
    <div class="card-body">
        <?php
        foreach($status_list as $server_name => $status) {
        ?>
            <div class="server_data row no-gutters">
                <div class="col-auto">
                    <span class="server_name"><?=$server_name?></span>                  
                </div>
                <div class="col server_bar">
                    <div class="captions clearfix">
                        <div class="float-left">
                            <?php
                            if($status['status'] == Yii::$app->AppHelper::$ONLINE) {
                                echo count($status['online_list']);
                            } else {
                                echo Yii::t('frontend','выключен');
                            }
                            ?>
                        </div>
                    </div>
                </div>
                
                
            </div>      
        <?php
        }
        ?>
    </div>
</div>
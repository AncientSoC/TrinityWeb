<?php
/**
 * @author Eugene Terentev <eugene@terentev.net>
 * @var string $maintenanceText
 * @var int|string $retryAfter
 */
?>
<div id="maintenance-content" style="margin-top: 10%">
    <p class="well">
        <?php echo Yii::t('app', $maintenanceText, [
            'retryAfter' => $retryAfter
        ]) ?>
    </p>
</div>
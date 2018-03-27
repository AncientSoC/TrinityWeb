<?php

namespace frontend\modules\api\v1\controllers;

use yii\rest\ActiveController;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\helpers\ArrayHelper;
use yii\helpers\VarDumper;

use common\models\UserPaymentHistory;

use frontend\components\freeKassa\events\GatewayEvent;
use frontend\components\freeKassa\actions\ResultAction;


/**
 * Class PaymentController
 */
class PaymentController extends Controller
{
    
    public $enableCsrfValidation = false;


    protected $componentName = 'freeKassa';
    
    public function init()
    {
        parent::init();
        /** @var Api $pm */
        $freeKassa = \Yii::$app->get($this->componentName);
        $freeKassa->on(GatewayEvent::EVENT_PAYMENT_REQUEST, [$this, 'handlePaymentRequest']);
        $freeKassa->on(GatewayEvent::EVENT_PAYMENT_SUCCESS, [$this, 'handlePaymentSuccess']);
    }
    
    public function actions()
    {
        return [
            'result' => [
                'class' => ResultAction::className(),
                'componentName' => $this->componentName,
                'redirectUrl' => ['/site/index'],
                'sendConfirmationResponse' => true
            ],
            'success' => [
                'class' => ResultAction::className(),
                'componentName' => $this->componentName,
                'redirectUrl' => ['/site/index'],
                'silent' => true,
                'sendConfirmationResponse' => false
            ],
            'failure' => [
                'class' => ResultAction::className(),
                'componentName' => $this->componentName,
                'redirectUrl' => ['/site/index'],
                'silent' => true,
                'sendConfirmationResponse' => false
            ]
       ];
    }
    
    /**
     * @param GatewayEvent $event
     * @return bool
     */
    public function handlePaymentRequest($event)
    {
        $invoice = UserPaymentHistory::findOne(ArrayHelper::getValue($event->gatewayData, 'MERCHANT_ORDER_ID'));
        if (
                !$invoice instanceof UserPaymentHistory ||
                $invoice->status != UserPaymentHistory::STATUS_SUCCESS ||
                ArrayHelper::getValue($event->gatewayData, 'AMOUNT') != $invoice->amount ||
                ArrayHelper::getValue($event->gatewayData, 'MERCHANT_ID') != \Yii::$app->get($this->componentName)->merchantId
            ) return;
        $invoice->operation_data = VarDumper::dumpAsString($event->gatewayData);
        $event->invoice = $invoice;
        $event->handled = true;
    }

    /**
     * @param GatewayEvent $event
     * @return bool
     */
    public function handlePaymentSuccess($event)
    {
        $invoice = $event->invoice;
        $invoice->status = UserPaymentHistory::STATUS_COMPLETE;
        $invoice->sign = ArrayHelper::getValue($event->gatewayData, 'SIGN');
        $invoice->currency_id = ArrayHelper::getValue($event->gatewayData, 'CUR_ID');
        $invoice->amount = ArrayHelper::getValue($event->gatewayData, 'AMOUNT');
        $invoice->merchant_id = ArrayHelper::getValue($event->gatewayData, 'MERCHANT_ID');
        $invoice->operation_time_complete = time();
        $invoice->save();
    }
    
}

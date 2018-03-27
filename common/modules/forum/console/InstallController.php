<?php

namespace common\modules\forum\console;

use yii\console\Controller;
use common\modules\forum\maintenance\Installation;
use yii\helpers\Console;

/**
 * Podium command line interface to RBAC managment
 *
 * @author pavlm
 */
class InstallController extends Controller
{

    /**
     * Init forum Installing.
     */
    public function actionInit()
    {
        Console::output("Installing forum...");
        @unlink(\Yii::getAlias('@base') . '/steps');
        
        $type = null;
        $percent = null;
        
        $max = 500;
        $_it = 1;
        
        while($type != 2 && $percent != 100 && $_it != $max) {
            $stepResult = $this->runStep();
            $type = $stepResult['type'];
            $percent = $stepResult['percent'];
            $_it++;
        }
        @unlink(\Yii::getAlias('@base') . '/steps');
        Console::output("Done!");
    }
    
    protected function runStep() {
        $installation = new Installation();
        $result = $installation->nextStepConsole();
        return $result;
    }
    
}
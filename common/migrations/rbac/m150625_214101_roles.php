<?php

use common\models\User;
use common\rbac\Migration;

class m150625_214101_roles extends Migration
{
    public function up()
    {
        $this->auth->removeAll();

        $user = $this->auth->createRole(User::ROLE_USER);
        $this->auth->add($user);
        
        $manager = $this->auth->createRole(User::ROLE_MODERATOR);
        $this->auth->add($manager);
        $this->auth->addChild($manager, $user);

        $admin = $this->auth->createRole(User::ROLE_ADMINISTRATOR);
        $this->auth->add($admin);
        $this->auth->addChild($admin, $manager);
        
        $intepreter = $this->auth->createRole(User::ROLE_INTERPRETER);
        $this->auth->add($intepreter);
        $this->auth->addChild($admin, $intepreter);
    }

    public function down()
    {
        $this->auth->remove($this->auth->getRole(User::ROLE_ADMINISTRATOR));
        $this->auth->remove($this->auth->getRole(User::ROLE_MODERATOR));
        $this->auth->remove($this->auth->getRole(User::ROLE_USER));
    }
}

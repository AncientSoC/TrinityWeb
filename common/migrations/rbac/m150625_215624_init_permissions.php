<?php

use common\rbac\Migration;

class m150625_215624_init_permissions extends Migration
{
    public function up()
    {
        $moderatorRole = $this->auth->getRole(\common\models\User::ROLE_MODERATOR);
        $intepreterRole = $this->auth->getRole(\common\models\User::ROLE_INTERPRETER);
        $loginToBackend = $this->auth->createPermission(\common\models\User::PERM_LOGIN_TO_BACKEND);
        $this->auth->add($loginToBackend);
        $this->auth->addChild($moderatorRole, $loginToBackend);
        $this->auth->addChild($intepreterRole, $loginToBackend);
    }

    public function down()
    {
        $this->auth->remove($this->auth->getPermission('loginToBackend'));
    }
}

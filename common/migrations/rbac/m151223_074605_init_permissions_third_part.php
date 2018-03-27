<?php

use common\rbac\Migration;

use common\rbac\rule\OwnModelRule;

class m151223_074605_init_permissions_third_part extends Migration
{
    public function up()
    {
        $moderatorRole = $this->auth->getRole(\common\models\User::ROLE_MODERATOR);
        $adminRole = $this->auth->getRole(\common\models\User::ROLE_ADMINISTRATOR);
        $userRole = $this->auth->getRole(\common\models\User::ROLE_USER);
        
        $accessToBugTracker = $this->auth->createPermission(\common\models\User::PERM_ACCESS_TO_BUGTRACKER);
        $accessToTasks = $this->auth->createPermission(\common\models\User::PERM_ACCESS_TO_TASKS);
        $accessToProjects = $this->auth->createPermission(\common\models\User::PERM_ACCESS_TO_PROJECTS);
        $accessToCreateTask = $this->auth->createPermission(\common\models\User::PERM_ACCESS_TO_CREATE_TASK);
        $accessToChangeTask = $this->auth->createPermission(\common\models\User::PERM_ACCESS_TO_CHANGE_TASK);
        $accessToDeleteTask = $this->auth->createPermission(\common\models\User::PERM_ACCESS_TO_DELETE_TASK);
        
        $accessToEditOwnTask = $this->auth->createPermission(\common\models\User::PERM_ACCESS_TO_EDIT_OWN_TASK);
        $rule = $this->auth->getRule('ownModelRule');
        $accessToEditOwnTask->ruleName = $rule->name;
        
        $this->auth->add($accessToBugTracker);
        $this->auth->add($accessToProjects);
        $this->auth->add($accessToTasks);
        $this->auth->add($accessToCreateTask);
        $this->auth->add($accessToChangeTask);
        $this->auth->add($accessToDeleteTask);
        $this->auth->add($accessToEditOwnTask);
        
        $this->auth->addChild($moderatorRole, $accessToChangeTask);
        
        $this->auth->addChild($adminRole, $accessToDeleteTask);
        $this->auth->addChild($adminRole, $accessToProjects);
        
        $this->auth->addChild($userRole, $accessToBugTracker);
        $this->auth->addChild($userRole, $accessToTasks);
        $this->auth->addChild($userRole, $accessToCreateTask);
        $this->auth->addChild($userRole, $accessToEditOwnTask);
    }

    public function down()
    {
        $this->auth->remove($this->auth->getPermission(\common\models\User::PERM_ACCESS_TO_BUGTRACKER));
        $this->auth->remove($this->auth->getPermission(\common\models\User::PERM_ACCESS_TO_TASKS));
        $this->auth->remove($this->auth->getPermission(\common\models\User::PERM_ACCESS_TO_CREATE_TASK));
        $this->auth->remove($this->auth->getPermission(\common\models\User::PERM_ACCESS_TO_CHANGE_TASK));
        $this->auth->remove($this->auth->getPermission(\common\models\User::PERM_ACCESS_TO_DELETE_TASK));
    }
}

<?php

use common\rbac\Migration;

class m150625_215625_init_permissions_second_part extends Migration
{
    public function up()
    {
        $moderatorRole = $this->auth->getRole(\common\models\User::ROLE_MODERATOR);
        $adminRole = $this->auth->getRole(\common\models\User::ROLE_ADMINISTRATOR);
        $intepreterRole = $this->auth->getRole(\common\models\User::ROLE_INTERPRETER);
        
        $accessToTileLine = $this->auth->createPermission(\common\models\User::PERM_ACCESS_TO_TIMELINE);
        $accessToContent = $this->auth->createPermission(\common\models\User::PERM_ACCESS_TO_CONTENT);
        $accessToForum = $this->auth->createPermission(\common\models\User::PERM_ACCESS_TO_FORUM);
        $accessToRbac = $this->auth->createPermission(\common\models\User::PERM_ACCESS_TO_RBAC);
        $accessToI18N = $this->auth->createPermission(\common\models\User::PERM_ACCESS_TO_I18N);
        $accessToKeyValue = $this->auth->createPermission(\common\models\User::PERM_ACCESS_TO_KEY_VALUE);
        $accessToFileStorage = $this->auth->createPermission(\common\models\User::PERM_ACCESS_TO_FILE_STORAGE);
        $accessToCache = $this->auth->createPermission(\common\models\User::PERM_ACCESS_TO_CACHE);
        $accessToFileManager = $this->auth->createPermission(\common\models\User::PERM_ACCESS_TO_FILE_MANAGER);
        $accessToSysInformation = $this->auth->createPermission(\common\models\User::PERM_ACCESS_TO_SYS_INFORMATION);
        $accessToLogs = $this->auth->createPermission(\common\models\User::PERM_ACCESS_TO_LOGS);
        $accessToStore = $this->auth->createPermission(\common\models\User::PERM_ACCESS_TO_STORE);
        $accessToUsers = $this->auth->createPermission(\common\models\User::PERM_ACCESS_TO_USES);
        
        $this->auth->add($accessToTileLine);
        $this->auth->add($accessToContent);
        $this->auth->add($accessToForum);
        $this->auth->add($accessToRbac);
        $this->auth->add($accessToI18N);
        $this->auth->add($accessToKeyValue);
        $this->auth->add($accessToFileStorage);
        $this->auth->add($accessToCache);
        $this->auth->add($accessToFileManager);
        $this->auth->add($accessToSysInformation);
        $this->auth->add($accessToLogs);
        $this->auth->add($accessToStore);
        $this->auth->add($accessToUsers);
        
        $this->auth->addChild($moderatorRole, $accessToTileLine);
        $this->auth->addChild($moderatorRole, $accessToForum);
        $this->auth->addChild($moderatorRole, $accessToLogs);
        
        $this->auth->addChild($intepreterRole, $accessToI18N);
        
        $this->auth->addChild($adminRole, $accessToContent);
        $this->auth->addChild($adminRole, $accessToKeyValue);
        $this->auth->addChild($adminRole, $accessToFileStorage);
        $this->auth->addChild($adminRole, $accessToCache);
        $this->auth->addChild($adminRole, $accessToFileManager);
        $this->auth->addChild($adminRole, $accessToSysInformation);
        $this->auth->addChild($adminRole, $accessToRbac);
        $this->auth->addChild($adminRole, $accessToStore);
        $this->auth->addChild($adminRole, $accessToUsers);
    }

    public function down()
    {
        $this->auth->remove($this->auth->getPermission(\common\models\User::PERM_ACCESS_TO_TIMELINE));
        $this->auth->remove($this->auth->getPermission(\common\models\User::PERM_ACCESS_TO_CONTENT));
        $this->auth->remove($this->auth->getPermission(\common\models\User::PERM_ACCESS_TO_FORUM));
        $this->auth->remove($this->auth->getPermission(\common\models\User::PERM_ACCESS_TO_I18N));
        $this->auth->remove($this->auth->getPermission(\common\models\User::PERM_ACCESS_TO_KEY_VALUE));
        $this->auth->remove($this->auth->getPermission(\common\models\User::PERM_ACCESS_TO_RBAC));
        $this->auth->remove($this->auth->getPermission(\common\models\User::PERM_ACCESS_TO_FILE_STORAGE));
        $this->auth->remove($this->auth->getPermission(\common\models\User::PERM_ACCESS_TO_CACHE));
        $this->auth->remove($this->auth->getPermission(\common\models\User::PERM_ACCESS_TO_FILE_MANAGER));
        $this->auth->remove($this->auth->getPermission(\common\models\User::PERM_ACCESS_TO_SYS_INFORMATION));
        $this->auth->remove($this->auth->getPermission(\common\models\User::PERM_ACCESS_TO_LOGS));
        $this->auth->remove($this->auth->getPermission(\common\models\User::PERM_ACCESS_TO_STORE));
        $this->auth->remove($this->auth->getPermission(\common\models\User::PERM_ACCESS_TO_USES));
    }
}

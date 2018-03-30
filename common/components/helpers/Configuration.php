<?php

namespace common\components\helpers;

class Configuration
{
    const CONFIGURED = 'configured';
    const ENABLED = 'enabled';
    const DISABLED = 'disabled';
    const INSTALLED = 'installed';
    
    // Basic Configs
    const APP_NAME           = 'app.name';
    const APP_STATUS         = 'app.status';
    
    // DBS
    const DB_STATUS          = 'db.status';
    const DB_WEB_STATUS      = 'db.web.status';
    const DB_RBAC_STATUS     = 'db.rbac.status';
    const DB_LANG_STATUS     = 'db.lang.status';
    const DB_FORUM_STATUS    = 'db.forum.status';
    
    const AUTH_STATUS        = 'auth.status';
    const CHARS_STATUS       = 'chars.status';
    
    // Emails
    const ADMIN_EMAIL      = 'email.admin';
    const ROBOT_EMAIL      = 'email.robot';
    const EMAIL_STATUS      = 'email.status';
    
    // Modules
    const MODULE_FORUM     = 'module.forum';
    const MODULE_DB_ARMORY    = 'module.db.armory';
    const MODULE_ARMORY    = 'module.armory';
    const MODULE_ARMORY_PER_PAGE    = 'module.armory.per_page';
    const MODULE_LADDER    = 'module.ladder';
    const MODULE_LADDER_PER_PAGE    = 'module.ladder.per_page';
    const MODULE_STORE     = 'module.store';
    const MODULE_API       = 'module.api';
    
    // RECAPTCHA
    const RECAPTCHA_SITE_KEY = 'recaptcha.site.key';
    const RECAPTCHA_SECRET  = 'recaptcha.secret';
    const RECAPTCHA_STATUS  = 'recaptcha.status';
    
}
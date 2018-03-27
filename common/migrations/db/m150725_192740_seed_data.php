<?php

use common\models\User;
use yii\db\Migration;

class m150725_192740_seed_data extends Migration
{
    public function safeUp()
    {
        $this->insert('{{%key_storage_item}}', [
            'key' => 'backend.theme-skin',
            'value' => 'skin-blue',
            'comment' => 'skin-blue, skin-black, skin-purple, skin-green, skin-red, skin-yellow'
        ]);

        $this->insert('{{%key_storage_item}}', [
            'key' => 'backend.layout-fixed',
            'value' => 0
        ]);

        $this->insert('{{%key_storage_item}}', [
            'key' => 'backend.layout-boxed',
            'value' => 0
        ]);

        $this->insert('{{%key_storage_item}}', [
            'key' => 'backend.layout-collapsed-sidebar',
            'value' => 0
        ]);

        $this->insert('{{%key_storage_item}}', [
            'key' => 'frontend.maintenance',
            'value' => 'disabled',
            'comment' => 'Set it to "enabled" to turn on maintenance mode'
        ]);
        
        $this->insert('{{%key_storage_item}}', [
            'key' => 'frontend.database_url',
            'value' => 'https://wotlk.cavernoftime.com',
            'comment' => 'wow database url - require version wotlk'
        ]);
        
        $this->insert('{{%key_storage_item}}', [
            'key' => 'frontend.database_icon_url_large',
            'value' => 'https://cdn.cavernoftime.com/wotlk/icons/large',
            'comment' => '{LARGE} wow database image url - require version wotlk'
        ]);
        
        $this->insert('{{%key_storage_item}}', [
            'key' => 'frontend.database_icon_url_medium',
            'value' => 'https://cdn.cavernoftime.com/wotlk/icons/medium',
            'comment' => '{MEDIUM} wow database image url - require version wotlk'
        ]);
        
        $this->insert('{{%key_storage_item}}', [
            'key' => 'frontend.cache_ladder',
            'value' => '60',
            'comment' => 'Cache time in seconds - ladder list'
        ]);
        
        $this->insert('{{%key_storage_item}}', [
            'key' => 'frontend.cache_armory_search',
            'value' => '120',
            'comment' => 'Cache time in seconds - armory search'
        ]);
        
        $this->insert('{{%key_storage_item}}', [
            'key' => 'frontend.cache_armory_character',
            'value' => '60',
            'comment' => 'Cache time in seconds - armory character data'
        ]);
        
        $this->insert('{{%key_storage_item}}', [
            'key' => 'frontend.cache_armory_character_talents',
            'value' => '60',
            'comment' => 'Cache time in seconds - armory character talents data'
        ]);
        
        $this->insert('{{%key_storage_item}}', [
            'key' => 'frontend.cache_store_search',
            'value' => '120',
            'comment' => 'Cache time in seconds - store search'
        ]);
        
        $this->insert('{{%key_storage_item}}', [
            'key' => 'frontend.realmlist',
            'value' => 'logon.change.me',
            'comment' => 'Realmlist'
        ]);
    }

    public function safeDown()
    {
    }
}

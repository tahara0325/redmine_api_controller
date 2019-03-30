<?php

/*
 * redmine更新履歴テーブルの設定
 *
 * @author HirokiTahara
 */
class Model_Redmineapi extends \Orm\Model
{
    protected static $_properties = array(
        'issue_id',
        'user_name',
        'update_time',
    );
    protected static $_table_name = 'redmine_change_log';

    public static function _init()
    {
        
    }

    /**
     * DBに登録を行う
     * @param array $insert_data issue_idとuser_name
     */
    public static function insert_redmine_change_log($insert_data)
    {
        \Model\Db\redmine::insert_redmine(self::$_table_name, $insert_data);
    }

}

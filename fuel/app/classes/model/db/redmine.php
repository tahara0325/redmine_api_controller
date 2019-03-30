<?php

namespace Model\Db;

/**
 * チケットの更新
 * 履歴の取得
 *
 * @author HirokiTahara
 */
class redmine
{

    /**
     * レッドマイン更新履歴の更新
     * @param type $table 更新するテーブル名
     * @param type $insert_data 更新データ
     */
    public static function insert_redmine($table, $insert_data)
    {
        try {
            $query = \DB::insert($table)->set($insert_data);
            $query->execute();
        } catch (Exception $exc) {
            Log::write($table, 'insert error! no id no where');
        }
    }

    /**
     * CSVのダウンロードを行う
     * @return type csvデータ
     */
    public static function csv_dl()
    {
        //データ取得
        $query = \DB::select()->from('redmine_change_log');
        $member = $query->execute();

        // 出力情報の設定
        header("Content-Type: application/octet-stream");
        header("Content-Disposition: attachment; filename=redmine_change_log.csv");
        header("Content-Transfer-Encoding: UTF-8");

        $csv = null;

        // 1行目のラベルを作成
        $csv = '"issue_id","use_name","update_time"' . "\n";

        // 出力データ生成
        foreach ($member as $value) {
            $csv .= '"' . $value['issue_id'] . '","' . $value['user_name'] . '", "' . $value['update_time'] . '","' . "\n";
        }

        // CSVファイル出力
        echo $csv;
        exit;
        return;
    }

}

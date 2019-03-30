<?php

use \Model_Redmineapi;

/**
 * redmineのAPIリクエスト処理を行う
 *
 * @author HirokiTahara
 */
class Controller_General_Partner_Redmineapi extends Controller_Template
{

    public function action_index()
    {
        return \View::forge('general/partner/redmineapi', $this->view_data, false);
    }

    /*
     * チケットの一覧を表示する
     */

    public function post_entry()
    {
        //現在から1週間前の日付取得
        $end_day = date("Y-m-d", strtotime("- 7 day"));
        //開始日を設定
        $start_date = Input::post('start_date');
        //api keyを設定
        $api_kye = Input::post('api_kye');
        //セッションに保存
        Session::set('api_kye', $api_kye);

        //update時間が現在より1週間前のものを選択する
        $url = "http://red.affiliateb.net/time_entries.json?key=$api_kye&from=$start_date&to=$end_day&limit=25";

        //jsonの整形処理
        $json = file_get_contents($url);

        $json = mb_convert_encoding($json, 'UTF8', 'ASCII,JIS,UTF-8,EUC-JP,SJIS-WIN');

        $arr = json_decode($json, true);

        $json_str = json_encode($arr, JSON_UNESCAPED_UNICODE);

        //表示期間
        echo "開始日:$start_date 最終更新日:$end_day";
        echo nl2br("\n");

        //チケットの情報を出力する
        for ($i = 0; $i < 25; $i++) {
            //更新するデータを設定
            $isuue_no = $arr['time_entries'][$i]['issue']['id'];
            $user_name = $arr['time_entries'][$i]['user']['name'];

            echo ' issue id:  ';
            echo $arr['time_entries'][$i]['issue']['id'];
            echo ' プロジェクト: ';
            echo $arr['time_entries'][$i]['project']['name'];
            echo ' 状態: ';
            echo $arr['time_entries'][$i]['activity']['name'];
            echo ' 担当者: ';
            echo $arr['time_entries'][$i]['user']['name'];
            echo "<form action='update' method='post'><p><input type='hidden' name= 'issue_no' value='$isuue_no'></p><p><button input type='submit' name= 'user_name' value='$user_name'>ステータスを更新する</button></p></form>";
            echo nl2br("\n");
        }
    }

    /*
     * チケット更新の処理を行う
     * 
     */

    public function post_update()
    {

        //apiの設定
        $api_kye = Session::get('api_kye');

        //チケット番号の設定
        $issue_no = Input::post('issue_no');

        //DB登録処理
        $insert_data = Input::post();
        Model_Redmineapi::insert_redmine_change_log($insert_data);

        // チケットのステータスを設定
        $data = array(
            'issue' => array(
                'status_id' => '3'
            )
        );

        // JSON形式に変換
        $data = json_encode($data);

        // ストリームコンテキストのオプションを作成
        $options = array(
            // HTTPコンテキストオプションをセット
            'http' => array(
                'method' => 'PUT',
                'header' => 'Content-type: application/json; charset=UTF-8', //JSON形式で表示
                'content' => $data
            )
        );
        // ストリームコンテキストの作成
        $context = stream_context_create($options);
        // POST送信
        $contents = file_get_contents("http://red.affiliateb.net/issues/$issue_no.json?key=$api_kye", false, $context);
        // レスポンスを表示
        echo $contents;
    }

    /*
     * csvのダウンロード処理
     */

    public function post_csv_dl()
    {
        \Model\Db\redmine::csv_dl();
    }

}

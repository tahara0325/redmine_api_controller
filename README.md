## Fuellにredmine操作機能を追加するファイル
 
MVCファイルを設置することで以下の機能が追加されます。
1. １週間更新のないチケットの表示
3. チケットのステータスを保留に変更
2. 更新履歴をDBに保存
2. 更新履歴のCSVダウンロード

 
### 入力画面
　
![画像](https://github.com/tahara0325/redmine_api_controller/blob/master/image/redmineapi01.png)
 
取得開始日を設定し、現在から1週間更新のないチケットを表示する。
 
＊最大25件
 
### 表示画面
![画像](https://github.com/tahara0325/redmine_api_controller/blob/master/image/redmineapi02.png)

　
### テーブル構成

　
```
CREATE TABLE `redmine_change_log` (
  `issue_id` int(11) NOT NULL COMMENT 'チケット番号',
  `user_name` varchar(20) DEFAULT NULL COMMENT 'ユーザー名',
  `update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新時間',
  PRIMARY KEY (`issue_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
```

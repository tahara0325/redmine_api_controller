<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=yes,maximum-scale=1">
        <title>redmine api</title>
    </head>

    <body>
        <h3>現在から1週間更新がないチケットを表示する</h3>
        <form action="redmineapi/entry" method="post">
            <p>api kye： <input type="text" name="api_kye"></p>
            <p>指定開始日： <input type="date" name="start_date"></p>
            <p><input type="submit" value="表示"></p>
        </form>
        <form action='redmineapi/csv_dl' method='post'>

            <p><input type='submit' value='csv_dl'></p>
        </form>

    </body>
</html>
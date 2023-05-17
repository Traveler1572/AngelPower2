<?php
// サンプルのユーザ情報
$sampleUsername = "sampleuser";
$samplePassword = "samplepassword";

// POSTリクエストを受け取る
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    // 入力されたユーザ名とパスワードがサンプルと一致するか確認
    if ($username === $sampleUsername && $password === $samplePassword) {
        // ログイン成功
        echo "ログインに成功しました！";
    } else {
        // ログイン失敗
        echo "ユーザ名またはパスワードが正しくありません。";
    }
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>株式会社エンジェルパワー | 勤怠打刻システム ログイン画面</title>
</head>
<body>
    <h2>株式会社エンジェルパワー 勤怠打刻システム ログイン画面</h2>
    <div class="container">
    <form method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
        <label for="username">ユーザ名：</label>
        <input type="text" name="username" id="username" required><br>

        <label for="password">パスワード：</label>
        <input type="password" name="password" id="password" required><br>

        <input type="submit" value="ログイン">
    </form>
    </div>
</body>
</html>
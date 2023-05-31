<?php
// データベースの接続情報
$host = 'localhost';
$dbname = 'dakokutest';
$username = 'root';
$password = '';

try {
    // データベースに接続
    $db = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // 打刻削除処理
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete'])) {
        $recordId = $_POST['record_id'];

        // 打刻データを削除
        $stmt = $db->prepare("DELETE FROM attendance WHERE id = ?");
        $stmt->execute([$recordId]);
    }

    // 打刻履歴を取得
    $stmt = $db->query("SELECT * FROM attendance ORDER BY timestamp DESC");
    $attendanceRecords = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "エラー：" , $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>勤怠打刻システム</title>
</head>
<body>
    <h1>勤怠打刻システム</h1>

    <h2>打刻履歴</h2>
    <table>
        <tr>
            <th>従業員</th>
            <th>ステータス</th>
            <th>タイムスタンプ</th>
            <th>削除</th>
        </tr>
        <?php foreach ($attendanceRecords as $record): ?>
            <tr>
                <td><?php echo $record['employee_id']; ?></td>
                <td><?php echo $record['status']; ?></td>
                <td><?php echo $record['timestamp']; ?></td>
                <td>
                    <form method="post" action="">
                        <input type="hidden" name="record_id" value="<?php echo $record['id']; ?>">
                        <input type="submit" name="delete" value="削除">
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
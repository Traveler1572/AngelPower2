<?php
// データベースの接続情報
$host = 'localhost';
$dbname = 'dakokutest';             // サンプルDB名「your_database_name」
$username = 'root';                 // サンプルユーザ「your_username」
$password = '';                     // サンプルパスワード「your_password」

try {
    // データベースに接続
    $db = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // 打刻処理
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $timestamp = date('Y-m-d H:i:s');
        $employeeId = $_POST['employee_id'];
        $status = $_POST['status'];

        // 打刻データをデータベースに挿入
        $stmt = $db->prepare("INSERT INTO attendance (employee_id, status, timestamp) VALUES (?, ?, ?)");
        $stmt->execute([$employeeId, $status, $timestamp]);
    }

    // 従業員一覧を取得
    $stmt = $db->query("SELECT * FROM employees");
    $employees = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // 打刻履歴を取得
    $stmt = $db->query("SELECT * FROM attendance ORDER BY timestamp DESC");
    $attendanceRecords = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "エラー：" . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>勤怠打刻システム</title>
</head>
<body>
    <h1>勤怠打刻システム</h1>

    <h2>打刻</h2>
    <form method="post" action="">
        <label for="employee_id">従業員：</label>
        <select name="employee_id" id="employee_id">
            <?php foreach ($employees as $employee): ?>
                <option value="<?php echo $employee['id']; ?>"><?php echo $employee['name']; ?></option>
            <?php endforeach; ?>
        </select>
        <br>
        <label for="status">ステータス</label>
        <select name="status" id="status">
            <option value="入社">入社</option>
            <option value="退社">退社</option>
        </select>
        <br>
        <input type="submit" value="打刻">
    </form>

    <h2>打刻履歴</h2>
    <table>
        <tr>
            <th>従業員</th>
            <th>ステータス</th>
            <th>タイムスタンプ</th>
        </tr>
        <?php foreach ($attendanceRecords as $record): ?>
            <tr>
                <td><?php echo $record['employee_id']; ?></td>
                <td><?php echo $record['status']; ?></td>
                <td><?php echo $record['timestamp']; ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
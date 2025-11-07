<?php session_start(); ?>
<?php require 'dbconnect.php'; ?>
<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // POSTデータがある場合、セッションに保存
    $_SESSION['user'] = [
        'username' => $_POST['username'] ?? '',
        'userid' => $_POST['userid'] ?? '',
        'useraddress' => $_POST['useraddress'] ?? '',
        'userpassword' => $_POST['userpassword'] ?? '',
    ];

    // DBに登録
    $sql = $pdo->prepare("INSERT INTO users (user_id, name, mail, password) VALUES (?, ?, ?, ?)");
    $sql->execute([
        $_SESSION['user']['userid'],
        $_SESSION['user']['username'],
        $_SESSION['user']['useraddress'],
        $_SESSION['user']['userpassword'],
    ]);
}

// index.phpへリダイレクト
header('Location: index.php');
exit;
?>
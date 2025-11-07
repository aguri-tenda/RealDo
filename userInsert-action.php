<?php session_start(); ?>
<?php require 'dbconnect.php'; ?>
<?php

// ★ セッションからデータを取得
$username = $_SESSION['user_input']['name'] ?? '';
$userid = $_SESSION['user_input']['user_id'] ?? '';
$useraddress = $_SESSION['user_input']['address'] ?? '';
$userpassword_raw = $_SESSION['user_input']['password'] ?? ''; // 平文のパスワード

if (!empty($userid) && !empty($userpassword_raw)) {
    // 🚨 最重要！ パスワードをハッシュ化
    $hashed_password = password_hash($userpassword_raw, PASSWORD_DEFAULT);

    // DBに登録
    // 注意: usersテーブルの構造が (user_id, name, mail, password) の順であることを前提としています
    $sql = $pdo->prepare("INSERT INTO users (user_id, name, mail, password) VALUES (?, ?, ?, ?)");
    
    // 登録実行。平文のパスワードではなくハッシュ化されたパスワードを渡す
    $success = $sql->execute([
        $userid,
        $username,
        $useraddress,
        $hashed_password, // 🚨 ハッシュ化されたパスワード
    ]);

    if ($success) {
        // 登録が成功した場合、セッション（ユーザー情報）をクリアする
        unset($_SESSION['user_input']);
        $_SESSION['user'] = [
            'id' => $pdo->lastInsertId(),
            'name' => $username,
            'address' => $useraddress,
            'user_id' => $userid,
        ];

        // index.phpへリダイレクト
        header('Location: index.php');
        exit;
    } else {
        // 登録失敗時のエラー処理（例: ログ出力やエラー画面への遷移）
    }

} else {
    // 必須データがない場合はエラー画面などへリダイレクト
    // index.phpへリダイレクト
    header('Location: index.php');
    exit;
}


?>
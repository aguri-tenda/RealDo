<?php session_start(); ?>
<?php require 'parts/db-connect.php'; ?>
<?php

// セッションからデータを取得
$username = $_SESSION['user_update']['name'] ?? '';
$userid = $_SESSION['user_update']['user_id'] ?? '';
$useraddress = $_SESSION['user_update']['address'] ?? '';
$userpassword_raw = $_SESSION['user_update']['password'] ?? ''; // 平文のパスワード

if (!empty($userid) && !empty($userpassword_raw)) {
    $hashed_password = password_hash($userpassword_raw, PASSWORD_DEFAULT);

    // DBに登録
    $sql = $pdo->prepare("UPDATE users SET user_id = ?, name = ?, mail = ?, password = ? WHERE user_id = ?");
    
    $success = $sql->execute([
        $userid,
        $username,
        $useraddress,
        $hashed_password,
        $_SESSION['user']['userid']
    ]);

    if ($success) {
        // 登録が成功した場合、セッション（登録用のユーザー情報）をクリアする
        unset($_SESSION['user_update']);
        $_SESSION['user'] = [
            'name' => $username,
            'address' => $useraddress,
            'userid' => $userid,
        ];

        // index.phpへリダイレクト
        header('Location: index.php');
        exit;
    } else {
        // 登録失敗時のエラー処理（例: ログ出力やエラー画面への遷移）
        header('Location: error.php');
        exit;
    }

} else {
    // index.phpへリダイレクト
    header('Location: index.php');
    exit;
}


?>
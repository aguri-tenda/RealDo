<?php session_start(); ?>
<?php require 'parts/db-connect.php'; ?>
<?php

// セッションからデータを取得
$providername = $_SESSION['provider_update']['providername'] ?? '';
$providerid = $_SESSION['provider_update']['providerid'] ?? '';
$provideraddress = $_SESSION['provider_update']['provideraddress'] ?? '';
$providerpassword_raw = $_SESSION['provider_update']['password'] ?? ''; // 平文のパスワード

if (!empty($providerid) && !empty($providerpassword_raw)) {
    $hashed_password = password_hash($providerpassword_raw, PASSWORD_DEFAULT);

    // DBに登録
    $sql = $pdo->prepare("UPDATE providers SET provider_id = ?, name = ?, mail = ?, password = ? WHERE provider_id = ?");
    
    $success = $sql->execute([
        $providerid,
        $providername,
        $provideraddress,
        $hashed_password,
        $_SESSION['provider']['providerid']
    ]);

    if ($success) {
        // 登録が成功した場合、セッション（登録用のユーザー情報）をクリアする
        unset($_SESSION['provider_update']);
        $_SESSION['provider'] = [
            'providername' => $providername,
            'provideraddress' => $provideraddress,
            'providerid' => $providerid,
        ];

        // provider-index.phpへリダイレクト
        header('Location: provider-index.php');
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
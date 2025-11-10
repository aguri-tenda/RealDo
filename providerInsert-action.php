<?php session_start(); ?>
<?php require 'parts/db-connect.php'; ?>
<?php

// セッションからデータを取得
$providername = $_SESSION['provider_input']['providername'] ?? '';
$providerid = $_SESSION['provider_input']['providerid'] ?? '';
$provideraddress = $_SESSION['provider_input']['provideraddress'] ?? '';
$providerpassword_raw = $_SESSION['provider_input']['providerpassword'] ?? ''; // 平文のパスワード

if (!empty($providerid) && !empty($providerpassword_raw)) {
    $hashed_password = password_hash($providerpassword_raw, PASSWORD_DEFAULT);

    // DBに登録
    $sql = $pdo->prepare("INSERT INTO providers (provider_id, name, mail, password) VALUES (?, ?, ?, ?)");
    
    $success = $sql->execute([
        $providerid,
        $providername,
        $provideraddress,
        $hashed_password,
    ]);

    if ($success) {
        // 登録が成功した場合、セッション（登録用のユーザー情報）をクリアする
        unset($_SESSION['provider_input']);
        $_SESSION['provider'] = [
            'id' => $pdo->lastInsertId(),
            'name' => $providername,
            'address' => $provideraddress,
            'provider_id' => $providerid,
        ];

        // index.phpへリダイレクト
        header('Location: provider-index.php');
        exit;
    } else {
        // 登録失敗時のエラー処理（例: ログ出力やエラー画面への遷移）
    }

} else {
    // 必須データがない場合はエラー画面などへリダイレクト
    // index.phpへリダイレクト
    header('Location: provider-index.php');
    exit;
}


?>
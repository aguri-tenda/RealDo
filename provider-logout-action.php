<?php session_start(); ?>
<?php
// セッションを破棄してログアウト処理を行う
session_unset();
session_destroy();
// ログインページにリダイレクト
header("Location: provider-login.php");
exit();
?>
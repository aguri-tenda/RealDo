<?php
session_start();

// 入力データを受け取り、セッションに保存
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $_SESSION['user'] = [
        'username' => $_POST['username'] ?? '',
        'userid' => $_POST['userid'] ?? '',
        'useraddress' => $_POST['useraddress'] ?? '',
        'userpassword' => $_POST['userpassword'] ?? '',
    ];
}

// セッションから値を取得
$name = $_SESSION['user']['username'] ?? '';
$id = $_SESSION['user']['userid'] ?? '';
$address = $_SESSION['user']['useraddress'] ?? '';
$password = $_SESSION['user']['userpassword'] ?? '';
?>



<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.3/css/bulma.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css">

    <title>RealDo</title>
</head>

<body>
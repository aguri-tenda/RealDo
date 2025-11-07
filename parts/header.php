<?php
session_start();

// セッションから値を取得
$name = $_SESSION['user']['username'] ?? '';
$user_id = $_SESSION['user']['userid'] ?? '';
$address = $_SESSION['user']['useraddress'] ?? '';
$password = $_SESSION['user']['userpassword'] ?? '';

$provider_name = $_SESSION['provider']['providername'] ?? '';
$provider_id = $_SESSION['provider']['provider_id'] ?? '';
$provider_address = $_SESSION['provider']['provideraddress'] ?? '';
$provider_password = $_SESSION['provider']['providerpassword'] ?? '';
?>



<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.3/css/bulma.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css">
    <style>
        body {
            padding-bottom: 90px;
            /* フッター高さ分の余白 */
        }
    </style>
    <title>RealDo</title>
</head>

<body>
<?php
    const SERVER = 'mysql327.phy.lolipop.lan';
    const DBNAME = 'LAA1607564-realdo';
    const USER = 'LAA1607564';
    const PASS = 'PassTeamE';

    $connect = 'mysql:host=' . SERVER . ';dbname=' . DBNAME . ';charset=utf8';
    $pdo = new PDO($connect, USER, PASS);
?>
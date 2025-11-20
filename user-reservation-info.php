<?php session_start();?>
<?php require "parts/header.php"; ?>
<?php require "parts/navigation.php"; ?>
    <span class="subtitle is-4" style="color:#278EDD;">いちご狩りへの予約状況</span>
<?php
if(!empty($_SESSION['product'])){
    echo '<table>';
    echo '<tr><td>参加日時:</td><td>場所:</td><td>発売日:</td><td>参加人数:</td></tr>';
}
    foreach($_SESSION['product']){
        
    }
?>
<?php require "parts/user_bottom.php"; ?>
<?php require "parts/footer.php"; ?>
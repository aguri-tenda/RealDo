<?php session_start();?>
<?php require "parts/header.php"; ?>
<?php require "parts/navigation.php"; ?>
<?php require "parts/db-connect.php"; ?>
    <span class="subtitle is-4" style="color:#278EDD;">いちご狩りへの予約状況</span>
<?php
$pdo=new PDO(
    $connect,USER,PASS
);
$sql=$pdo->prepare('select*from product where id=?');
$sql->execute([$_GET['id']]);
foreach($sql as $row){
    $id=$row['id'];
    echo '<form action=".php" method="post">';
    echo '<p>参加日時:',$row['id'],'</p>';
    echo '<p>場所:',$product['location'],'</p>';
    echo '<p>所在地:',$product['address'],'</p>';
    echo '<p>参加人数:',$product['max_participants'];
    
    echo '<input type="hidden" name="id" value="',$row['id'],'">';
    echo '<input type="hidden" name="name" value="',$row['name'],'">';
    echo '<input type="hidden" name="location" value="',$product['location'],'">';
    echo '<input type="hidden" name="address" value="',$product['address'],'">';
    echo '<input type="hidden" name="primax_participants" value="',$product['max_participants'],'">';
    echo '<p><input type="submit" value="戻る"></p>';
    echo '</form>';  
}
?>
<?php require "parts/user_bottom.php"; ?>
<?php require "parts/footer.php"; ?>
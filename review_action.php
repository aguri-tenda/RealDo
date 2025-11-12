<?php session_start(); ?>
<?php require 'parts/db-connect.php'; ?>
<?php
$product_id = $_SESSION['review']['product_id'] ?? '';
$user_id = $_SESSION['user']['userid'] ?? '';
$rating = $_SESSION['review']['rating-value'] ?? 1;
$reviewtext = $_SESSION['review']['reviewtext'] ?? '';

if (!empty($rating) && !empty($reviewtext)) {
    $sql = $pdo->prepare("INSERT INTO reviews (product_id, user_id,rating,date,text) VALUES (?, ?, ?,NOW(), ?)");

    $INSERT = $sql->execute([
        $product_id,
        $user_id,
        $rating,
        $reviewtext,
    ]);
    header('Location: index.php');
}
?>
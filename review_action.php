<?php session_start(); ?>
<?php require 'parts/db-connect.php'; ?>
<?php
$product_id = $_SESSION['review']['product_id'] ?? '';
$user_id = $_SESSION['user']['userid'] ?? '';
$rating = $_SESSION['review']['rating'] ?? 1;
$reviewtext = $_SESSION['review']['reviewtext'] ?? '';

if ($product_id && $user_id && $rating >= 1 && $rating <= 5 && !empty($reviewtext)) {
    $sql = $pdo->prepare("INSERT INTO reviews (product_id, user_id,rating,date,text) VALUES (?, ?, ?,NOW(), ?)");

    $INSERT = $sql->execute([
        $product_id,
        $user_id,
        $rating,
        $reviewtext,
    ]);
    header('Location: index.php');
} else {
    echo "レビューの登録に失敗しました。必要な情報が不足しているか、無効な値が含まれています。";
    //ホーム画面へ戻るリンク
    echo '<div class="field has-text-centered" style="margin-top: 20px; margin-bottom: 40px;">
    <a href="index.php" class="button is-info is-medium"
    style="background-color: #278EDD; width: 250px;">ホーム画面へ</a>
    </div>';
}
?>
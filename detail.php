<?php require "parts/header.php"; ?>
<?php require "parts/navigation.php"; ?>
<?php require "parts/db-connect.php"; ?>

<?php
$product_id = $_GET['product_id'] ?? null;
if ($product_id === null) {
    echo "<p>Product ID is missing.</p>";
    exit;
}
$sql = prepare("SELECT * FROM products WHERE id = ?");
$sql->execute([$product_id]);
$product = $sql->fetch(PDO::FETCH_ASSOC);

$sql2 = prepare("SELECT * FROM purchases WHERE product_id = ? AND user_id = ?");
?>


<div class="container" style="margin-top: 2rem; margin-bottom: 2rem;">
</div>

<?php require "parts/provider_bottom.php"; ?>
<?php require "parts/footer.php"; ?>

<?php require "parts/header.php"; ?>
<?php require "parts/navigation.php"; ?>
<?php require "parts/db-connect.php"; ?>

<?php
$product_id = $_GET['product_id'] ?? null;
if ($product_id === null) {
    echo "<p>Product ID is missing.</p>";
    exit;
}
$sql = $pdo->prepare("SELECT * FROM products WHERE id = ?");
$sql->execute([$product_id]);
$product = $sql->fetch(PDO::FETCH_ASSOC);
?>


<div class="container" style="margin-top: 2rem; margin-bottom: 2rem;">
    <div class="box" style="padding: 2rem;">
        <div class="columns">
            <div class="column is-one-third">
                <figure class="image is-4by3">
                    <img src="<?= htmlspecialchars($product['image_pass']) ?>" alt="Product Image">
                </figure>
            </div>
            <div class="column">
                
            </div>
        </div>
    </div>
</div>

<?php require "parts/provider_bottom.php"; ?>
<?php require "parts/footer.php"; ?>

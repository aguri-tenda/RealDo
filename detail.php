<?php require "parts/header.php"; ?>
<?php require "parts/navigation.php"; ?>
<?php require "parts/db-connect.php"; ?>

<?php
$product_id = $_GET['product_id'] ?? null;
if ($product_id === null) {
    echo "<p>Product ID is missing.</p>";
    exit;
}
$sql = $pdo->prepare("SELECT * FROM products WHERE product_id = ?");
$sql->execute([$product_id]);
$product = $sql->fetch(PDO::FETCH_ASSOC);
$tags_sql = $pdo->prepare(
    "SELECT t.tag_name
    FROM attached_tags att
    INNER JOIN tags t
        ON att.tag_id = t.tag_id
    WHERE att.product_id = ?"
);
$tags_sql->execute([$product_id]);
$tags = $tags_sql->fetchAll(PDO::FETCH_ASSOC);
$dates_sql = $pdo->prepare("SELECT * FROM dates WHERE product_id = ? ORDER BY date ASC");
$dates_sql->execute([$product_id]);
$dates = $dates_sql->fetchAll(PDO::FETCH_ASSOC);
?>


<div class="container has-text-centered" style="margin-top: 2rem; margin-bottom: 2rem;">
    <div class="field is-horizontal" style="padding: 2rem;">
        <figure class="image is-4by3">
            <img src="<?= htmlspecialchars($product['image_pass']) ?>" alt="<?= htmlspecialchars($product['name']) ?>">
        </figure>
    </div>
</div>

<?php require "parts/provider_bottom.php"; ?>
<?php require "parts/footer.php"; ?>

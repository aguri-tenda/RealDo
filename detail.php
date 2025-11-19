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
    <div class="field is-horizontal is-justify-content-center mt-5">
        <figure class="image is-256x256 is-inline-block">
            <img src="<?= htmlspecialchars($product['image_pass']) ?>" alt="<?= htmlspecialchars($product['name']) ?>">
        </figure>
    </div>

    <div class="box" style="margin: 25px; display: flex; align-items: center;">
        <div style="flex-grow: 1;">
            <p>
                <span class="title is-4"><?= htmlspecialchars($product['name']) ?></span>

                <?php foreach( $tags as $tag ) : ?>
                    <span><button class="button is-small is-primary is-outlined is-rounded" disabled><?= $tag['tag_name']; ?></button></span>
                <?php endforeach; ?>
            </p>

            <p><<?= nl2br(htmlspecialchars($product['detail'])) ?></p>

            <p><strong>場所:</strong> <?= htmlspecialchars($product['location']) ?></p>
            <p><strong>所在地:</strong> <?= htmlspecialchars($product['address']) ?></p>
            <p><strong>参加人数:</strong>
                <?= htmlspecialchars($product['max_participants']) ?>/<?= htmlspecialchars($product['max_participants']) ?>人
            </p>
        </div>

        <div class="media-right" style="display: flex; flex-direction: column; gap: 10px; margin-left: 20px;">
            <span class="title is-6">￥<?= htmlspecialchars($product['price']) ?></span>
            <a href="booking.php?product_id=<?= htmlspecialchars($product['product_id']) ?>" class="button" style="background-color:#27ea6bff; color: white;">予約</a>
        </div>
    </div>
</div>

<?php require "parts/provider_bottom.php"; ?>
<?php require "parts/footer.php"; ?>

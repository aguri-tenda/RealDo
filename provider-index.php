<?php require "parts/header.php"; ?>
<?php require "parts/provider_navigation.php"; ?>
<?php require "parts/db-connect.php"; ?>

<?php
// 商品一覧を取得
if( isset($_SESSION['provider']['providerid']) )
    {
        $sql = $pdo->prepare("SELECT * FROM products WHERE provider_id = ?");
        $sql->execute([$_SESSION['provider']['providerid']]);
        $products = $sql->fetchAll(PDO::FETCH_ASSOC);
    }
?>

<div class="columns is-gapless">
    <div class="column is-narrow" style="background-color: #79D159; min-height: 100vh; padding: 0;">
        <aside class="menu" style="padding: 25px; width: 200px;">
            <ul class="menu-list">
                <li>
                    <a href="#" class="is-active" style="background-color: #55B537; color: white;">商品一覧</a>
                </li>
                <hr>
                <li>
                    <a href="product-insert.php" style="color: white;">商品登録</a>
                </li>
                <hr>
                <li>
                    <a href="product-management.php" style="color: white;">商品管理</a>
                </li>
                <hr>
            </ul>
        </aside>
    </div>

    <div class="column">
        <h1 class="title is-3" style="margin: 25px;">商品一覧</h1>
        <hr style="margin-top: -10px;">

        <?php if (!empty($products)): ?>
            <?php foreach ($products as $product): ?>
                <div class="box" style="margin: 25px; display: flex; align-items: center;">
                    <div style="flex-grow: 1;">
                        <p class="title is-4"><?= htmlspecialchars($product['name']) ?></p>
                        <span class="tag is-success is-light" style="margin-bottom: 10px;">体験</span>
                        <p><strong>所在地:</strong> <?= htmlspecialchars($product['address']) ?></p>
                        <p><strong>参加人数:</strong>
                            <?= htmlspecialchars($product['max_participants']) ?>/<?= htmlspecialchars($product['max_participants']) ?>人
                        </p>
                    </div>
                    <div style="flex-shrink: 0; margin-left: 20px;">
                        <img src="img/<?= htmlspecialchars($product['image_path'] ?? 'default_product.png') ?>"
                            alt="<?= htmlspecialchars($product['product_name']) ?>"
                            style="width: 150px; height: 100px; object-fit: cover; border-radius: 5px;">
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="box" style="margin: 25px;">
                <p>現在、登録されている商品はありません。</p>
                <a href="product-insert.php" class="button is-link is-light" style="margin-top: 15px;">商品登録はこちらから</a>
            </div>
        <?php endif; ?>

    </div>
</div>



<?php require "parts/provider_bottom.php"; ?>
<?php require "parts/footer.php"; ?>
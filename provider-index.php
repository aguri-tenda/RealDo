<?php require "parts/header.php"; ?>
<?php require "parts/provider_navigation.php"; ?>
<?php require "parts/db-connect.php"; ?>

<?php
// 商品一覧を取得
$sql = $pdo->prepare("SELECT * FROM products WHERE provider_id = ?");
$sql->execute([$provider_id]);
$products = $sql->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="columns is-gapless">
    <div class="column is-narrow" style="background-color: #79D159; min-height: 100vh; padding: 0;">
        <aside class="menu" style="padding: 25px; width: 250px;">
            <ul class="menu-list">
                <li>
                    <a href="#" class="is-active" style="background-color: #55B537; color: white;">商品一覧</a>
                </li>
                <li>
                    <a href="product-insert.php" style="color: white;">商品登録</a>
                </li>
                <li>
                    <a href="product-update.php" style="color: white;">商品管理</a>
                </li>
            </ul>
        </aside>
    </div>

    <div class="column">

    </div>
</div>



<?php require "parts/provider_bottom.php"; ?>
<?php require "parts/footer.php"; ?>
<?php require "parts/header.php"; ?>
<?php require "parts/provider_navigation.php"; ?>
<?php require "parts/db-connect.php"; ?>

<?php
$product_id = $_POST['product_id'];
$sql = $pdo->prepare("SELECT 
                        purchases.*, users.name
                      FROM purchases
                      JOIN users ON purchases.user_id = users.user_id
                      WHERE product_id = ?
                      AND is_active = 1
                      ORDER BY purchased_date DESC;");
$sql->execute([$product_id]);
$purchases = $sql->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="columns is-gapless">
    <div class="column is-narrow" style="background-color: #79D159; min-height: 100vh; padding: 0;">
        <aside class="menu" style="padding: 25px; width: 200px;">
            <ul class="menu-list">
                <li>
                    <a href="provider-index.php" style="color: white;">商品一覧</a>
                </li>
                <hr>
                <li>
                    <a href="product-insert.php" style="color: white;">商品登録</a>
                </li>
                <hr>
                <li>
                    <a href="#" class="is-active" style="background-color: #55B537; color: white;">商品管理</a>
                </li>
                <hr>
            </ul>
        </aside>
    </div>

    <div class="column">
        <div class="level">
            <div class="level-left">
                <a href="<?= $_SERVER['HTTP_REFERER']; ?>"><input type="button" class="button is-link ml-4" value="戻る"></a>
                <h1 class="title is-3" style="margin: 25px;">予約情報一覧</h1>
            </div>
        </div>

        <?php if ($purchases): ?>
            <?php foreach ($purchases as $purchase): ?>
                <div class="box" style="margin: 25px; display: flex; align-items: center;">
                            
                    <div style="flex-grow: 1;">
                        <h2 class="title is-4"><?= htmlspecialchars($purchase['name']) ?></h2>
                        <p>参加日時: <?= htmlspecialchars($purchase['start_time']) ?></p>
                        <p>参加人数: <?= htmlspecialchars($purchase['attendance']) ?></p>
                        <p>連絡先: <?= htmlspecialchars($purchase['tel']) ?></p>
                        <p>購入日: <?= htmlspecialchars($purchase['purchased_date']) ?></p>
                    </div>
                    
                    <div class="media-right" style="display: flex; flex-direction: column; gap: 10px; margin-left: 40px;">
                        <h2 class="title is-4">備考</h2>
                        <p><?= $purchase['remarks'] != '' ? nl2br(htmlspecialchars($purchase['remarks'])) : 'なし' ?></p>
                    </div>

                    
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p style="margin: 25px;">予約情報はありません。</p>
        <?php endif; ?>
    </div>

</div>

<?php require "parts/provider_bottom.php"; ?>
<?php require "parts/footer.php"; ?>
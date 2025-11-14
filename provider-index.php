<?php require "parts/header.php"; ?>
<?php require "parts/provider_navigation.php"; ?>
<?php require "parts/db-connect.php"; ?>

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

<?php if( isset($_SESSION['provider'])) : ?>
    <?php
        $sql = $pdo->prepare("SELECT * FROM products WHERE provider_id = ? && is_active = 1 ;");
        $sql->execute([$_SESSION['provider']['providerid']]);
        $products = $sql->fetchAll(PDO::FETCH_ASSOC);
    ?>

        <?php if ($products): ?>
            <?php foreach ($products as $product): ?>
                
                <?php
                    $tag = $pdo->prepare( "SELECT * FROM attached_tags JOIN tags ON attached_tags.tag_id = tags.tag_id WHERE product_id = ? ;" );
                    $tag->execute([ $product['product_id'] ]);
                ?>

                <div class="box" style="margin: 25px; display: flex; align-items: center;">
                    <div style="flex-grow: 1;">
                        <p>
                            <span class="title is-4"><?= htmlspecialchars($product['name']) ?></span>

                            <?php foreach( $tag as $tags ) : ?>
                                <span><button class="button is-small is-primary is-outlined is-rounded" disabled><?= $tags['name']; ?></button></span>
                            <?php endforeach; ?>
                        </p>

                        <p><strong>場所:</strong> <?= htmlspecialchars($product['location']) ?></p>
                        <p><strong>所在地:</strong> <?= htmlspecialchars($product['address']) ?></p>
                        <p><strong>参加人数:</strong>
                            <?= htmlspecialchars($product['max_participants']) ?>/<?= htmlspecialchars($product['max_participants']) ?>人
                        </p>
                    </div>
                    <div style="flex-shrink: 0; margin-left: 20px;">
                        <img src="<?= htmlspecialchars($product['image_pass']) ?>"
                            alt="<?= htmlspecialchars($product['name']) ?>"
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

        <?php else :?>
    <p>商品一覧を見るにはログインしてください</p>
<?php endif; ?>

    </div>
</div>



<?php require "parts/provider_bottom.php"; ?>
<?php require "parts/footer.php"; ?>
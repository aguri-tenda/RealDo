<?php require "parts/header.php"; ?>
<?php require "parts/provider_navigation.php"; ?>
<?php require "parts/db-connect.php"; ?>

<?php
    $islogin = false;

    if( isset($_SESSION['provider']['providerid']) )
    {
        $sql = $pdo->prepare( "SELECT * FROM providers WHERE is_active = 1 AND provider_id = ? ;" );
        $sql->execute([ $_SESSION['provider']['providerid'] ]);

        $islogin = $sql->fetchAll( PDO::FETCH_ASSOC );
    }
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
        <?php if( $islogin) : ?>
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

                        <div class="media-right">
                        <form action="provider-reservation-info.php" method="post">
                            <input type="hidden" name="product_id" value="<?= $product['product_id']; ?>">

                            <button class="button is-primary is-rounded">予約情報を見る</button>
                        </form>

                        <script>
                            function deleteAlert( name, id )
                            {
                                if( confirm( name + "の掲載を取りやめます。\nよろしいですか？" ))
                                {
                                    window.location.href="product-delete-output.php?product_id=" + id;
                                }
                            }
                        </script>
                        <button class="button is-danger is-rounded" onclick="deleteAlert('<?= htmlspecialchars($product['name'], ENT_QUOTES) ; ?>', <?= $product['product_id'] ; ?>)">商品を削除</button>
                        </div>
                    </div>
                <?php endforeach; ?>
                <?php else : ?>
                    <p>まだ商品が登録されていません。</p>
            <?php endif; ?>

        <?php else : ?>
            <p>商品の管理をするためにはログインしてください。</p>
        <?php endif; ?>
    </div>
</div>

<?php require "parts/provider_bottom.php"; ?>
<?php require "parts/footer.php"; ?>
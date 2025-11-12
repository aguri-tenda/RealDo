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

<div class="section">
    <?php if( $islogin ) : ?>
        <?php
            $sql = $pdo->prepare( "SELECT * FROM products LEFT JOIN dates ON products.product_id = dates.product_id WHERE provider_id = ? ;" );
            $sql->execute([ $_SESSION['provider']['providerid'] ]);

            $products = $sql->fetchAll( PDO::FETCH_ASSOC );
        ?>

        <?php if( $products ) : ?>
            <?php foreach( $products as $product ) : ?>
                <?php
                    $sql = $pdo->prepare( "SELECT * FROM attached_tags LEFT JOIN tags ON tags.tag_id = attached_tags.tag_id WHERE product_id = ? ;" );
                    $sql->execute([ $product['product_id'] ]);
                    $tags = $sql->fetchAll( PDO::FETCH_ASSOC );
                ?>

                <div class="box has-background-light" style="border-radius: 20px; ">
                    <div class="media">
                        <div class="media-left">
                            <div style="text-align: left;">
                                <span>
                                    <span class="title is-h5"><?= $product['name']; ?></span>
                                        <?php foreach( $tags as $tag ) : ?>
                                        <button class="button is-small is-light is-rounded" disabled><?= $tag['name']; ?></button>
                                        <?php endforeach; ?>
                                </span>

                                <div>
                                    <p>
                                        開催日時：<?= $product['start_time']; ?>
                                    </p>

                                    <p>
                                        場所：<?= $product['location']; ?>
                                    </p>

                                    <p>
                                        所在地：<?= $product['address']; ?>
                                    </p>

                                    <p>
                                        参加人数：<?= $product['max_participants']; ?>
                                    </p>

                                </div>
                            </div>
                        </div>
                        <div class="media-content">
                            <p class="image is-128x128" style="align-content: center;">
                                <img src="<?= $product['image_path']; ?>" alt="サムネイル">
                            </p>
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
                </div>
            <?php endforeach; ?>
        <?php else : ?>
            <p>まだ商品が登録されていません。</p>
        <?php endif; ?>

    <?php else : ?>
        <p>商品の管理をするためにはログインしてください。</p>
    <?php endif; ?>
</div>

<?php require "parts/provider_bottom.php"; ?>
<?php require "parts/footer.php"; ?>
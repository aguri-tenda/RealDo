<?php session_start(); ?>

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
            $product = $pdo->prepare( "SELECT * FROM products LEFT JOIN dates ON product_id WHERE provider_id = ? ;" );
            $product->execute([ $_SESSION['provider']['providerid'] ]);

            $isproduts = $products->fetchAll( PDO::FETCH_ASSOC );
        ?>

        <?php if( $isproduts ) : ?>
            <?php foreach( $product as $products ) : ?>
                <?php
                    $tag = $pdo->prepare( "SELECT * FROM attached_tags LEFT JOIN tags ON product_id WHERE product_id = ? ;" );
                    $tag->execute([ $products['product_id'] ]);
                ?>

                <div class="box has-background-light" style="border-radius: 20px; ">
                    <div class="media">
                        <div class="media-left">
                            <div style="text-align: left;">
                                <span><span class="title is-h5"><?= $products['name']; ?></span><?php foreach( $tag as $tags ) : ?><button class="button is-small is-light is-rounded" disabled><?= $tags['name']; ?></button><?php endforeach; ?></span>

                                <div>
                                    <p>
                                        開催日時：<?= $products['start_time']; ?>
                                    </p>

                                    <p>
                                        場所：<?= $products['location']; ?>
                                    </p>

                                    <p>
                                        所在地：<?= $products['address']; ?>
                                    </p>

                                    <p>
                                        参加人数：<?= $products['max_participants']; ?>
                                    </p>

                                </div>
                            </div>
                        </div>
                        <div class="media-content">
                            <p class="image is-128x128" style="align-content: center;">
                                <img src="<?= $products['image_path']; ?>" alt="サムネイル">
                            </p>
                        </div>
                        <div class="media-right">
                            <form action="  ---#予約確認画面URL#---  " method="post">
                                <input type="hidden" name="product_id" value="<?= $products['product_id']; ?>">

                                <button class="button is-primary is-rounded">予約情報を見る</button>
                            </form>
                
                            <script>
                                function deleteAlert( name, id )
                                {
                                    if( confirm( name + "の掲載を取りやめます。\nよろしいですか？" ))
                                    {
                                        $delete = $pdo->prepare( "UPDATE product SET is_active = 0 WHERE product_id = ? ;" );
                                        $delete->execute([ id ]);

                                        location.reload();
                                    }
                                }
                            </script>
                            <button class="button is-danger is-rounded" click="deleteAlert(<?= $products['name'] ; ?>, <?= $products['product_id'] ; ?>)">商品を削除</button>
                
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
<?php require "parts/header.php"; ?>
<?php require "parts/navigation.php"; ?>

<?php require "parts/count_members.php"; ?>

<?php
    $islogin = false;

    if( isset($_SESSION['user']['userid']) )
    {
        $sql = $pdo->prepare( "SELECT * FROM users WHERE is_active = 1 AND user_id = ? ;" );
        $sql->execute([ $_SESSION['user']['userid'] ]);

        $islogin = $sql->fetchAll( PDO::FETCH_ASSOC );
    }
?>

<div class="section">
    <div class="container">
        <?php if($islogin) : ?>
            <?php
                $sql = $pdo->prepare("SELECT * FROM purchases JOIN products ON purchases.product_id = products.product_id WHERE user_id = ? AND purchases.is_active = 1 ;");
                $sql->execute([$_GET['user_id']]);

                $products = $sql->fetchAll(PDO::FETCH_ASSOC);
            ?>
            <div>
                <div class="level">
                    <a href="index.php"><input type="button" class="button is-link item-left" value="戻る"></a>
                    <h3 class="title is-3 has-text-centerd level-item" style="color:#278EDD;">予約中の商品</h3>
                </div>
                <?php if($products) : ?>
                    <div>
                        <?php foreach($products as $product) : ?>
                            <?php
                                $tags = $pdo->prepare( "SELECT * FROM attached_tags JOIN tags ON attached_tags.tag_id = tags.tag_id WHERE product_id = ? ;" );
                                $tags->execute([ $product['product_id'] ]);
                            ?>
                            <div class="box has-background-light" style="margin: 25px; display: flex; align-items: center;">
                                <div style="flex-grow: 1;">
                                    <p>
                                        <span class="title is-4"><?= htmlspecialchars($product['name']) ?></span>

                                        <?php foreach($tags as $tag) : ?>
                                            <span><button class="button is-small is-primary is-outlined is-rounded" disabled><?= $tag['name']; ?></button></span>
                                        <?php endforeach; ?>
                                    </p>

                                    <p><strong>参加日時:</strong><?= htmlspecialchars($product['start_time']) ?></p>
                                    <p><strong>場所:</strong><?= htmlspecialchars($product['location']) ?></p>
                                    <p><strong>所在地:</strong><?= htmlspecialchars($product['address']) ?></p>
                                    <p><strong>参加人数:</strong><?= countMembers($pdo, $product['product_id']) ?>/<?= htmlspecialchars($product['max_participants']) ?>人</p>

                                </div>

                                <div style="flex-shrink: 0; margin-left: 20px;">
                                    <img src="<?= htmlspecialchars($product['image_pass']) ?>" alt="<?= htmlspecialchars($product['name']) ?>" style="width: 150px; height: 100px; object-fit: cover; border-radius: 5px;">
                                </div>

                                <div class="media-right" style="display: flex; flex-direction: column; gap: 10px; margin-left: 20px;">

                                    <script>
                                        function deactivateAlert( name, purchaseid, userid )
                                        {
                                            if( confirm( name + "への予約を取り消します。\nよろしいですか？" ))
                                            {
                                                window.location.href="purchase-active-flag.php?purchase_id=" + purchaseid + "&user_id=" + userid;
                                            }
                                        }
                                    </script>
                                    
                                    <button class="button is-danger is-rounded" onclick="deactivateAlert('<?= htmlspecialchars($product['name'], ENT_QUOTES) ; ?>', <?= $product['purchase_id'] ; ?>, '<?= $_GET['user_id']; ?>')">予約取り消し</button>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else : ?>
                    <p>現在、予約している商品はありません。</p>
                <?php endif; ?>
            </div>
        <?php else :?>
                
            <p>予約情報を見るにはログインが必要です。</p>
        <?php endif; ?>
    </div>
</div>

<?php require "parts/user_bottom.php"; ?>
<?php require "parts/footer.php"; ?>
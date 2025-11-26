<?php require "parts/header.php"; ?>
<?php require "parts/navigation.php"; ?>

<?php
    $islogin = false;

    if( isset($_SESSION['user']) )
    {
        $sql = $pdo->prepare( "SELECT * FROM users WHERE is_active = 1 AND user_id = ? ;" );
        $sql->execute([ $_SESSION['user']['userid'] ]);
        $islogin = $sql->fetchAll( PDO::FETCH_ASSOC );
    }
?>

<div class="section" id="recommend-app">
    <div class="container">
        <?php if( $islogin ) : ?>

            <?php unset($_SESSION['search_params']); ?>

            <div class="card" style="background-color: #FFFDDF;">

                <?php
                    $getTag = $pdo->prepare(" SELECT tag_id FROM tag_count WHERE user_id = ? AND attention_level = (SELECT MAX(attention_level) FROM tag_count WHERE user_id = ? ); ");
                    $getTag->execute([ $_SESSION['user']['userid'], $_SESSION['user']['userid'] ]);

                    $getTagIds = $getTag->fetchAll(PDO::FETCH_ASSOC);

                    $getProducts = "";
                    $productIds = [];
                    $tagIds = [];
                ?>

                <?php if($getTagIds) : ?>
                <?php
                    foreach( $getTagIds as $getTagId ) 
                    {
                        array_push($tagIds, $getTagId['tag_id']);
                    }

                    do
                    {
                        if( count($tagIds) > 1)
                        {
                            $joinedTable = "";
                            $count = 1;
                            foreach( $tagIds as $tagId ) 
                            {

                                if($count > 1)
                                {
                                    $table = "(SELECT * FROM attached_tags WHERE tag_id = ". $tagId. ") AS searchedTable". $tagId;
                                    $joinedTable = $joinedTable. " JOIN ". $table. " ON searchedTable". ($count-1). ".product_id = searchedTable". $count. ".product_id";
                                }
                                else
                                {
                                    $joinedTable = "(SELECT * FROM attached_tags WHERE tag_id = ". $tagId. ") AS searchedTable". $tagId;
                                }
                                $count++;
                            }

                            $query = "SELECT * FROM ". $joinedTable. ";";
                            $getProducts = $pdo->query($query);


                            foreach( $getProducts as $product )
                            {
                                array_push($productIds, $product['product_id']);
                                $productIds = array_unique($productIds);
                            }
                        }
                        else
                        {
                            $getProducts = $pdo->prepare(" SELECT * FROM products JOIN attached_tags ON products.product_id = attached_tags.product_id WHERE tag_id = ? ORDER BY products.product_id DESC; ");
                            $getProducts->execute([ $tagIds[0] ]);

                            foreach( $getProducts as $product )
                            {
                                array_push($productIds, $product['product_id']);
                                $productIds = array_unique($productIds);

                                while( count($productIds) < 4 )
                                {
                                    array_push($productIds, 0);
                                }
                            }
                        }


                        if( count($tagIds) > 1 )
                        {
                            array_pop($tagIds);
                        }

                    }while( count($productIds) < 4 );
                    


                    while( count($productIds) > 4)
                    {
                        array_pop($productIds);
                    }

                ?>

                <div class="card-header">
                    <div class="card-header-icon">
                        <i class="fas fa-thumbs-up"></i>
                    </div>
                    <div class="card-header-title">
                        <span>あなたへのおすすめ</span>
                    </div>
                </div>

                <div class="card-content">
                    <div class="columns">

                        <?php foreach( $productIds as $productid ) : ?>
                            <?php
                                $productInfo = $pdo->prepare(" SELECT * FROM products WHERE product_id = ? ; ");
                                $productInfo->execute([ $productid ]);

                                $attachedTags = $pdo->prepare(" SELECT * FROM attached_tags JOIN tags ON attached_tags.tag_id = tags.tag_id WHERE product_id = ?;");
                                $attachedTags->execute([ $productid ]);
                            ?>
                            <?php foreach($productInfo as $recommend) : ?>
                            <div class="column">
                                <a href="detail.php?product_id=<?= $recommend['product_id']; ?>">
                                <div class="card is-rounded">
                                    <div class=card-header>
                                        <div class="card-header-title">
                                            <strong><?= $recommend['name']; ?></strong>
                                        </div>
                                    </div>
                                    <div class="card-image">
                                        <div class="image ">
                                            <img src="<?= $recommend['image_pass']; ?>" alt="<?= $recommend['name']; ?>">
                                        </div>
                                    </div>

                                    <div class="card-content">
                                        <div class="content">
                                            <p>
                                                <?php foreach( $attachedTags as $tags ) :?>
                                                    <button class="button is-small is-light is-rounded" disabled><?= $tags['name']; ?></button>
                                                <?php endforeach; ?>
                                            </p>

                                            <p><textarea readonly rows="4" style="width:100%; resize:none;" class="textarea is-primary"><?= $recommend['detail']; ?></textarea></p>
                                        </div>
                                    </div>
                                </div>
                                </a>
                            </div>
                            <?php endforeach; ?>
                        <?php endforeach; ?>

                    </div>
                </div>

                <?php else : ?>

                <div class="card-header">
                    <div class="card-header-icon">
                        <i class="fas fa-thumbs-up"></i>
                    </div>
                    <div class="card-header-title">
                        <span>商品の閲覧、購入等を行うと、あなたへのおすすめを見ることができます。</span>
                    </div>
                </div>

                <?php endif; ?>

            </div>
        <?php else : ?>
            <div class="card" style="background-color: #FFFDDF;">
                <div class="card-header">
                    <div class="card-header-icon">
                        <i class="	fas fa-info-circle"></i>
                    </div>
                    <div class="card-header-title">
                        <span>ログインすると、あなたへのおすすめを受け取ることができます。</span>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<div class="section">
    <div class="container is-fluid">
        <div class="level">
            <button href="booking_confirm.php" class="button is-large is-primary level-item has-textcenterd">
                予約情報確認
            </button>
        </div>
    </div>
</div>

<div class="section">
    <div class="container">
    </div>
</div>

<?php require "parts/user_bottom.php"; ?>
<?php require "parts/footer.php"; ?>
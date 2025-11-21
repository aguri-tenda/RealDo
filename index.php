<?php require "parts/header.php"; ?>
<?php require "parts/navigation.php"; ?>
<?php require "parts/db-connect.php"; ?>

<?php
    $islogin = false;

    if( isset($_SESSION['user']) )
    {
        $sql = $pdo->prepare( "SELECT * FROM users WHERE is_active = 1 AND user_id = ? ;" );
        $sql->execute([ $_SESSION['user']['userid'] ]);//利用者用に変更

        $islogin = $sql->fetchAll( PDO::FETCH_ASSOC );
    }
?>

<div class="section" id="recommend-app">
    <div class="container">
        <?php if( $islogin ) : ?>

            <div class="card" style="background-color: #FFFDDF;">
                <div class="card-header">
                    <div class="card-header-icon">
                        <i class="fas fa-thumbs-up"></i>
                    </div>
                    <div class="card-header-title">
                        <span>あなたへのおすすめ</span>
                    </div>
                </div>

                <?php
                    $getTagIds = $pdo->prepare(" SELECT tag_id FROM tag_count WHERE user_id = ? AND attention_level = (SELECT MAX(attention_level) FROM tag_count WHERE user_id = ? ); ");
                    $getTagIds->execute([ $_SESSION['user']['userid'], $_SESSION['user']['userid'] ]);

                    $getProducts = "";
                    $productIds = [];
                    $tagIds = [];
                ?>
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

                        echo json_encode($tagIds,JSON_UNESCAPED_UNICODE);

                        if( count($tagIds) > 1 )
                        {
                            array_pop($tagIds);
                        }

                    }while( count($productIds) < 4 );
                    

                    echo json_encode($productIds, JSON_UNESCAPED_UNICODE);

                    while( count($productIds) > 4)
                    {
                        array_pop($productIds);
                    }

                    echo json_encode($productIds, JSON_UNESCAPED_UNICODE);
                ?>

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
                                <a href="#">
                                <div class="card is-rounded">
                                    <div class=card-header>
                                        <div class="card-header-title">
                                            <strong><?= $recommend['name']; ?></strong>
                                        </div>
                                    </div>
                                    <div class="card-image">
                                        <div class="image is-256x256">
                                            <img src="<?= $recommend['image_pass']; ?>" alt="<?= $recommend['name']; ?>">
                                        </div>
                                    </div>

                                    <div class="card-content">
                                        <div class="content">
                                            
                                            <?php foreach( $attachedTags as $tags ) :?>
                                                <button class="button is-small is-light is-rounded" disabled><?= $tags['name']; ?></button>
                                            <?php endforeach; ?>
                                            

                                            <p><textarea readonly cols="30" rows="3"><?= $recommend['detail']; ?></textarea></p>
                                        </div>
                                    </div>
                                </div>
                                </a>
                            </div>
                            <?php endforeach; ?>
                        <?php endforeach; ?>

                    </div>
                </div>
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
            <button href="booking_confirm.php" class="button is-primary level-item has-textcenterd">
                予約情報確認
            </button>
        </div>
    </div>
</div>

<?php require "parts/user_bottom.php"; ?>
<?php require "parts/footer.php"; ?>
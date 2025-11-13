<?php session_start(); ?>

<?php
    if(is_uploaded_file( $_FILES['file']['tmp_name']))
    {
        if( $_FILES['file']['type'] == "image/jpeg" || $_FILES['file']['type'] == "image/png" )
        {
            $file = "product-img/". basename($_FILES['file']['name']);
                
            if(!move_uploaded_file($_FILES['file']['tmp_name'], $file))
            {
                header('Location:product-insert.php');
                exit();
            }
        }
        else
        {
            header('Location:product-insert.php?failed="failed"');
            exit();
        }
    }
?>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.3/css/bulma.min.css">

<?php require "parts/db-connect.php"; ?>

<?php
    $sql = $pdo->prepare( "INSERT INTO products( name, location, post_code, address, detail, image_pass, price, tel, provider_id, max_participants ) VALUE( ?, ?, ?, ?, ?, ?, ?, ?, ?, ? ) ;" );
    $sql->execute([ $_POST['name'], $_POST['location'], $_POST['post-code'], $_POST['address'], $_POST['detail'], $file, $_POST['price'], $_POST['tel'], $_POST['provider_id'], $_POST['max'] ]);

    $product_id = $pdo->lastInsertId();

    $getTag = $pdo->prepare(" SELECT * FROM tags WHERE tag_id = ?; ");
    $tagname = [];

    foreach( $_POST['tags'] as $tagid )
    {
        $getTag->execute([ $tagid ]);//要変更
        foreach( $getTag as $tagData )
        {
            array_push($tagname, $tagData['name']);
        }
    }
    
    $sql = $pdo->prepare(" INSERT INTO attached_tags(product_id, tag_id) VALUEs( ? , ? );" );

    foreach( $_POST['tags'] as $tag )
    {
        $sql->execute([$product_id, $tag]);
    }
?>

<div class="has-background-light">
    <div class="container" id="app-product-insert">
        <div class="section">
            <div class="box has-background-white" style="color:#278EDD;">
                <div class="content level">
                    <h3 class="level-item" style="color:#278EDD;">商品登録完了</h3>
                </div>

                <form action="provider-index.php">
                    
                    <div class="level">
                        <div class="level-left">
                            <span>参加可能人数</span>
                            <input type="number" value="<?= $_POST['max']; ?>" size="3" disabled>
                            <span>人まで</span>
                        </div>
                        <div class="level-right">
                            <span>開催日時</span>
                            <div>
                                <input type="date" value="<?= $_POST['start_date']; ?>" disabled>
                                <input type="text" value="<?= $_POST['start_time']; ?>"  size="5" disabled>～
                            </div>
                        </div>
                    </div>

                    <hr>

                    <div class="table-container" style="overflow-y: scroll; height: 300px;">
                        <div class="level">
                            <p class="level-left">イベント情報</p>
                        </div>
                            
                        <div class="level">
                            <div class="level-item">
                                <div class="block">

                                    <div class="level">
                                        <div class="level-left">
                                            イベント名：
                                        </div>
                                        <div class="level-right">
                                            <input type="text" value="<?= $_POST['name']; ?>" disabled>
                                        </div>
                                    </div>

                                    <div class="level">
                                        <div class="level-left">
                                            開催地：
                                        </div>
                                        <div class="level-right">
                                            <input type="text" value="<?= $_POST['location']; ?>" disabled>
                                        </div>
                                    </div>

                                    <div class="level">
                                        <div class="level-left">
                                            開催地所在地：
                                        </div>
                                        <div class="level-right">
                                            <div>
                                                <div>
                                                    <input type="text" value="<?= $_POST['post-code']; ?>" size="8" disabled>
                                                    <input type="text" value="<?= $_POST['address']; ?>" disabled>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="level">
                                        <div class="level-left">
                                            <div>
                                                <p>主催連絡先（TEL）：</p>
                                            </div>
                                        </div>
                                        <div class="level-right">
                                            <div>
                                                <input type="text" value="<?= $_POST['tel']; ?>" disabled>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="level">
                                        <div class="level-left">
                                            商品の詳細：
                                        </div>
                                        <div class="level-right">
                                            <div>
                                                <textarea cols="25" rows="5" max="1000" disabled><?= $_POST['detail']; ?></textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="level">
                                        <div class="level-left">
                                            サムネイル画像：
                                        </div>
                                        <div class="level-right">
                                            <img src="<?= $file; ?>" width="100px">
                                        </div>
                                    </div>
                                    
                                    <div class="level">
                                        <div class="level-left">
                                            参加料：
                                        </div>
                                        <div class="level-right">
                                            <input type="number" value="<?= $_POST['price']; ?>" disabled>円
                                        </div>
                                    </div>

                                    <div class="level">
                                        <div class="level-left">
                                            タグ：
                                        </div>
                                        <div class="level-right">
                                                    
                                            <div>

                                            <?php
                                                $tagsCol = 0;
                                            ?>
                                            <?php foreach( $tagname as $tag ) : ?>
                                                            
                                                <span><?= $tag;?> </span>
                                                    <?php
                                                        $tagsCol++;
                                                        if( $tagsCol >= 3 )
                                                        {
                                                            echo "\n";
                                                        }
                                                    ?>
                                                <?php endforeach; ?>
                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>

                        </div>
                    </div>

                    <hr>

                    <div class="container is-fluid">
                        <div class="level">
                            <button class="button is-info level-item">ホーム画面へ</button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>    
</div>

<?php require "parts/provider_bottom.php"; ?>
<?php require "parts/footer.php"; ?>
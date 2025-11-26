<?php session_start(); ?>

<?php
    if(is_uploaded_file( $_FILES['file']['tmp_name']))
    {
        if( $_FILES['file']['type'] == "image/jpeg" || $_FILES['file']['type'] == "image/png" )
        {
            $file = "product-img/". basename($_FILES['file']['name']);
                
            if(!move_uploaded_file($_FILES['file']['tmp_name'], $file))
            {
                header('Location:product-update.php');
                exit();
            }
        }
        else
        {
            header('Location:product-update.php?failed="failed"');
            exit();
        }
    }
?>

<html>
    <head>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.3/css/bulma.min.css">
        <title>RealDo</title>
    </head>

<?php require "parts/db-connect.php"; ?>
<?php require "parts/address.php"; ?>

<div class="has-background-light">
    <?php
        $islogin = false;

        if( isset($_SESSION['provider']) )
        {
            $sql = $pdo->prepare( "SELECT * FROM providers WHERE is_active = 1 AND provider_id = ? ;" );
            $sql->execute([ $_SESSION['provider']['providerid'] ]);

            $islogin = $sql->fetchAll( PDO::FETCH_ASSOC );
        }
    ?>

    <?php if( $islogin ) : ?>

        <?php

            $datetimes = $pdo->prepare(" SELECT * FROM dates WHERE product_id = ? ; ");
            $datetimes->execute([ $_GET['product_id'] ]);

            $start_date = [];
            $start_time = [];

            $finish_date = [];
            $finish_time = [];

            $index = 0;

        ?>
    
        <div class="container" id="app-product-update">
            <div class="section">
                <div class="box has-background-white" style="color:#278EDD;">
                    <div class="content level">
                        <h3 class="level-item" style="color:#278EDD;">商品情報更新フォーム</h3>
                    </div>

                    <div v-if="toggleDateForm == true">
                        <div class="level">
                            <div class="level-right">
                                <input type="button" class="button is-link is-outlined" value="イベント情報の更新" @click="toggleForm">
                            </div>
                        </div>
                            <?php foreach( $datetimes as $datetime ) : ?>

                                <?php

                                    $start = explode(" ", $datetime['start_time']);
                                    $finish = explode(" ", $datetime['finish_time']);

                                    $trimedStartTime = substr($start[1], 0, 5);
                                    if( $trimedStartTime >= "00:00" && $trimedStartTime <= "09:59" )
                                    {
                                        $trimedStartTime = substr($trimedStartTime, 1, 4);
                                    }

                                    $trimedFinishTime = substr($finish[1], 0, 5);
                                    if( $trimedFinishTime >= "00:00" && $trimedFinishTime <= "09:59" )
                                    {
                                        $trimedFinishTime = substr($trimedFinishTime, 1, 4);
                                    }

                                    array_push($start_date, $start[0]);
                                    array_push($start_time, $trimedStartTime);

                                    array_push($finish_date, $finish[0]);
                                    array_push($finish_time, $trimedFinishTime);
                                ?>
                                    
                                <div>
                                    <span>    
                                        <input type="date" value="<?= $start_date[$index]; ?>" disabled>
                                        <input type="text" value="<?= $start_time[$index]; ?>" disabled>～
                                                    
                                        <input type="date" value="<?= $finish_date[$index]; ?>" disabled>
                                        <input type="text" value="<?= $finish_time[$index]; ?>" disabled>
                                    </span>

                                    <br>

                                </div>
                        
                                <?php $index++; ?>

                            <?php endforeach; ?>

                            <hr>
                    </div>

                    <div v-else>
                            <form action="product-management.php">
                    
                                <?php
                                    $products = $pdo->prepare(" SELECT * FROM products WHERE product_id = ?; ");
                                    $products->execute([ $_GET['product_id'] ]);
                                ?>
                                <?php foreach($products as $product) : ?>

                                    <?php

                                        $max = intval($product['max_participants']);
                                        $name = $product['name'];
                                        $location = $product['location'];
                                        $post_code = $product['post_code'];
                                        $address = $product['address'];
                                        $tel = $product['tel'];
                                        $detail = $product['detail'];
                                        $image_pass = $product['image_pass'];
                                        $price = intval($product['price']);
                                        

                                        if( $_POST['max'] != null )
                                        {
                                            $max = $_POST['max'];
                                        }

                                        if( !empty($_POST['name']) )
                                        {
                                            $name = $_POST['name'];
                                        }

                                        if( !empty($_POST['location']) )
                                        {
                                            $location = $_POST['location'];
                                        }

                                        if( !empty($_POST['post-code']) )
                                        {
                                            $post_code = $_POST['post-code'];
                                        }

                                        if( !empty($_POST['address']) )
                                        {
                                            $address = $_POST['address'];
                                        }

                                        if( !empty($_POST['tel']) )
                                        {
                                            $tel = $_POST['tel'];
                                        }

                                        if( !empty($_POST['detail']) )
                                        {
                                            $detail = $_POST['detail'];
                                        }

                                        if( isset($file) )
                                        {
                                            $oldPath = $file;
                                            $newPath = "product-img/". $_GET['product_id']. basename($_FILES['file']['name']);

                                            rename($oldPath, $newPath);
                                            $image_pass = $newPath;
                                        }

                                        if( $_POST['price'] != null )
                                        {
                                            $price = $_POST['price'];
                                        }

                                        if( !empty($_POST['tags']) )
                                        {
                                            $tagsql = $pdo->prepare(" DELETE FROM attached_tags WHERE product_id = ?; ");
                                            $tagsql->execute([ $_GET['product_id'] ]);

                                            $tagsql = $pdo->prepare(" INSERT INTO attached_tags(product_id, tag_id) VALUE( ?, ? ); ");

                                            foreach( $_POST['tags'] as $tag )
                                            {
                                                $tagsql->execute([$_GET['product_id'], $tag]);
                                            }
                                        }

                                        $gettag = $pdo->prepare(" SELECT * FROM attached_tags JOIN tags ON attached_tags.tag_id = tags.tag_id WHERE product_id = ? ;");
                                        $gettag->execute([ $_GET['product_id'] ]);


                                        $sql = $pdo->prepare(
                                            "UPDATE products SET name = ?, location = ?, post_code = ?, address = ?, detail = ?, image_pass = ?, price = ?, tel = ?, max_participants = ?, area = ?
                                            WHERE product_id = ? ");
                                        $sql->execute([ $name, $location, $post_code, $address, $detail, $image_pass, $price, $tel, $max, getAreaFromPostalCode( $post_code ), $_GET['product_id'] ]);
                                    ?>

                                <div class="level">
                                    <div class="level-left">
                                        <span>参加可能人数</span>
                                        <input type="number" value="<?= $max; ?>" size="3" disabled>
                                        <span>人まで</span>
                                    </div>
                                    <div class="level-right">
                                        <input type="button" class="button is-link is-outlined" value="開催日時の編集" @click="toggleForm">
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
                                                        <input type="text" value="<?= $name; ?>" disabled>
                                                    </div>
                                                </div>

                                                <hr>

                                                <div class="level">
                                                    <div class="level-left">
                                                        開催地：
                                                    </div>
                                                    <div class="level-right">
                                                        <input type="text" value="<?= $location; ?>" disabled>
                                                    </div>
                                                </div>

                                                <hr>

                                                <div class="level">
                                                    <div class="level-left">
                                                        開催地所在地：
                                                    </div>
                                                    <div class="level-right">
                                                        <div>
                                                            <div>
                                                                <input type="text" value="<?= $post_code; ?>" size="8" disabled>
                                                                <input type="text" value="<?= $address; ?>" disabled>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <hr>

                                                <div class="level">
                                                    <div class="level-left">
                                                        <div>
                                                            <p>主催連絡先（TEL）：</p>
                                                        </div>
                                                    </div>
                                                    <div class="level-right">
                                                        <div>
                                                            <input type="text" value="<?= $tel; ?>" disabled>
                                                        </div>
                                                    </div>
                                                </div>

                                                <hr>

                                                <div class="level">
                                                    <div class="level-left">
                                                        商品の詳細：
                                                    </div>
                                                    <div class="level-right">
                                                        <div>
                                                            <textarea cols="25" rows="5" max="1000" disabled><?= $detail; ?></textarea>
                                                        </div>
                                                    </div>
                                                </div>

                                                <hr>

                                                <div class="level">
                                                    <div class="level-left">
                                                        サムネイル画像：
                                                    </div>
                                                    <div class="level-right">
                                                        <img src="<?= $image_pass; ?>" width="100px">
                                                    </div>
                                                </div>
                                                            
                                                <hr>
                                    
                                                <div class="level">
                                                    <div class="level-left">
                                                        参加料：
                                                    </div>
                                                    <div class="level-right">
                                                        <input type="number" value="<?= $price; ?>" min="0" size="5" disabled>円
                                                    </div>
                                                </div>

                                                <hr>

                                                <div class="level">
                                                    <div class="level-left">
                                                        タグ：
                                                    </div>
                                                    <div class="level-right">
                                                        <div>

                                                            <?php foreach( $gettag as $tag ) : ?>
                                                                <span><?= $tag['name'];?> </span>
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
                                        <button class="button is-info level-item">商品管理画面へ</button>
                                    </div>
                                </div>

                                <?php endforeach; ?>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <script src="https://cdn.jsdelivr.net/npm/vue@2.7.11/dist/vue.js"></script>
            <script src="script/product-update-script.js"></script>
    

        <?php else : ?>
            <div class="section">
                <div class="container">
                    <p>ログインされていません。</p>
                </div>
            </div>
        <?php endif; ?>

<?php require "parts/provider_bottom.php"; ?>
<?php require "parts/footer.php"; ?>
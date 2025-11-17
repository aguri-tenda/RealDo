<?php require "parts/header.php"; ?>
<?php require "parts/provider_navigation.php"; ?>

<?php require "parts/db-connect.php"; ?>

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
            $products = $pdo->prepare(" SELECT * FROM products WHERE product_id = ?; ");
            $products->execute([ $_GET['product_id'] ]);

            if(isset($_POST['addDate']) && isset($_POST['new_start_date']) && isset($_POST['new_start_time']) && isset($_POST['new_finish_date']) && isset($_POST['new_finish_time']))
            {
                $sql = $pdo->prepare(" INSERT INTO dates( product_id, start_time, finish_time ) VALUE( ?, ?, ? );");
                $sql->execute([ $_GET['product_id'], $_POST['new_start_date']. " ". $_POST['new_start_time'], $_POST['new_finish_date']. " ". $_POST['new_finish_time'] ]);
            }

            if(isset($_POST['deleteDate']) && isset($_POST['delete_start_date']) && isset($_POST['delete_start_time']) && isset($_POST['delete_finish_date']) && isset($_POST['delete_finish_time']))
            {
                $sql = $pdo->prepare(" DELETE FROM dates WHERE product_id = ? AND start_time = ? AND finish_time = ? ;");

                $complementStartTime = $_POST['delete_start_time']. ":00";
                $complementFinishTime = $_POST['delete_finish_time']. ":00";

                if( strlen($complementStartTime) > 7)
                {
                    $complementStartTime = "0". $complementStartTime;
                }

                if( strlen($complementFinishTime) > 7)
                {
                    $complementFinishTime = "0". $complementFinishTime;
                }

                $sql->execute([ $_GET['product_id'], $_POST['delete_start_date']. " ". $complementStartTime, $_POST['delete_finish_date']. " ". $complementFinishTime ]);
            }

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
                            <div class="level-left content">
                                <p style="color:#278EDD;">このフォームでは開催期間を複数設定することができます</p>
                            </div>
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
                                        <form action="#" method="post">
                                            
                                            <input type="date" value="<?= $start_date[$index]; ?>" name="delete_start_date" readonly>
                                            <input type="text" value="<?= $start_time[$index]; ?>" name="delete_start_time" size="5" readonly>～
                                                    
                                            <input type="date" value="<?= $finish_date[$index]; ?>" name="delete_finish_date" readonly>
                                            <input type="text" value="<?= $finish_time[$index]; ?>" name="delete_finish_time" size="5" readonly>
                                            
                                            <input type="submit" value="開催日時の削除" name="deleteDate" class="button is-danger is-small is-outlined">
                                        </form>
                                    </span>

                                    <br>

                                </div>
                        
                                <?php $index++; ?>

                            <?php endforeach; ?>

                            <hr>

                            <form action="#" method="post">

                                <input type="date" v-model="start_date" name="new_start_date">
                                <input type="text" v-model="start_time" name="new_start_time" placeholder="0:00" size="5">～
                                                    
                                <input type="date" v-model="finish_date" name="new_finish_date">
                                <input type="text" v-model="finish_time" name="new_finish_time" placeholder="0:00" size="5">

                                <input type="submit" value="開催日時の追加" name="addDate" class="button is-primary is-small is-outlined" :disabled="isTime">

                                <p class="help" v-if="isTime">時間は「0:00 ~ 23:59」の間で設定してください</p>
                            </form>
                        </div>

                        <div v-else>
                            <form action="product-update-output.php?product_id=<?= $_GET['product_id']; ?>" method="post" enctype="multipart/form-data">
                    
                                <?php foreach($products as $product) : ?>
                                <div class="level">
                                    <div class="level-left">
                                        <span>参加可能人数</span>
                                        <input type="number" placeholder="<?= $product['max_participants']; ?>" v-model="max" name="max" size="3">
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
                                                        <input type="text" placeholder="<?= $product['name']; ?>"  v-model="name" name="name">
                                                    </div>
                                                </div>

                                                <hr>

                                                <div class="level">
                                                    <div class="level-left">
                                                        開催地：
                                                    </div>
                                                    <div class="level-right">
                                                        <input type="text" placeholder="<?= $product['location']; ?>"  v-model="location" name="location">
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
                                                                <input type="text" placeholder="<?= $product['post_code']; ?>"  v-model="addressNum" name="post-code" size="8">
                                                                <input type="text" placeholder="<?= $product['address']; ?>"  v-model="address" name="address">
                                                            </div>
                                                            <p class="help" v-if="isAddressNum">郵便番号は「xxx-xxxx」形式で入力してください</p>
                                                        </div>
                                                    </div>
                                                </div>

                                                <hr>

                                                <div class="level">
                                                    <div class="level-left">
                                                        <div>
                                                            <p>主催連絡先（TEL）：</p>
                                                            <p class="help">ハイフン不要</p>
                                                        </div>
                                                    </div>
                                                    <div class="level-right">
                                                        <div>
                                                            <input type="text" placeholder="<?= $product['tel']; ?>"  v-model="tel" name="tel">
                                                            <p class="help" v-if="isTel">数字で入力してください</p>
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
                                                            <textarea v-model="detail" name="detail" cols="25" rows="5" max="1000" placeholder="<?= $product['detail']; ?>"><?= $product['detail']; ?></textarea>
                                                            <p class="help">{{ detail.length }}/ 1000 <span v-if="isDetailOver"><font color="red">※文字数が超過しています</font></span> </p>
                                                        </div>
                                                    </div>
                                                </div>

                                                <hr>

                                                <div class="level">
                                                    <div class="level-left">
                                                        サムネイル画像：
                                                    </div>
                                                    <div class="level-right">
                                                        <div>
                                                            <input type="file" name="file" accept="image/*">
                                                            <?php if(isset($_GET['failed'])) : ?>
                                                                <p class="help"><font color="red">ファイルはpng、またはjpegを指定してください</font></p>
                                                            <?php endif; ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                            
                                                <hr>
                                    
                                                <div class="level">
                                                    <div class="level-left">
                                                        参加料：
                                                    </div>
                                                    <div class="level-right">
                                                        <input type="number" placeholder="<?= $product['price']; ?>"  v-model="price" min="0" size="5" name="price">円
                                                    </div>
                                                </div>

                                                <hr>

                                                <div class="level">
                                                    <div class="level-left">
                                                        <div>
                                                            <p>タグ：※３つまで</p>
                                                            <p class="help">変更しない場合は何も選択しないでください。</p>
                                                        </div>
                                                    </div>
                                                    <div class="level-right">
                                                        <?php 
                                                            $tags = $pdo->query( "SELECT * FROM tags;" );
                                                            $tagsCol = 0;
                                                        ?>
                                                    
                                                        <div>
                                                            <?php foreach( $tags as $tag ) : ?>

                                                                <?php 
                                                                    $attached = $pdo->prepare(" SELECT * FROM attached_tags WHERE product_id = ? AND tag_id = ?; ");
                                                                    $attached->execute([ $_GET['product_id'], $tag['tag_id'] ]);

                                                                    $isAttached = $attached->fetchAll( PDO::FETCH_ASSOC );
                                                                ?>
                                                            
                                                                <span>
                                                                    <input v-model="tags" type="checkbox" name="tags[]" value="<?= $tag['tag_id']; ?>"><?= $tag['name']; ?>
                                                                </span>

                                                                <?php
                                                                    $tagsCol++;
                                                                    if( $tagsCol >= 4 )
                                                                    {
                                                                        echo "<br>";
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
                           
                                        <button :disabled="isFullInput" class="button is-info level-item">更新</button>

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
                    <p>商品の更新をするにはログインしてください。</p>
                </div>
            </div>
        <?php endif; ?>

<?php require "parts/provider_bottom.php"; ?>
<?php require "parts/footer.php"; ?>
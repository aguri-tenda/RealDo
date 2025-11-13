<?php require "parts/header.php"; ?>
<?php require "parts/provider_navigation.php"; ?>
<?php require "parts/db-connect.php"; ?>

<div class="has-background-light">
    <div class="container" id="app-product-insert">
        <div class="section">
            <div class="box has-background-white" style="color:#278EDD;">
                <div class="content level">
                    <h3 class="level-item" style="color:#278EDD;">商品情報更新フォーム</h3>
                </div>

                <form action="product-update-output.php" method="post" enctype="multipart/form-data">
                    
                    <div class="level">
                        <div class="level-left">
                            <span>参加可能人数</span>
                            <input type="number" v-model="max" name="max" size="3" required>
                            <span>人まで</span>
                        </div>
                        <div class="level-right">
                            <span>開催日時</span>
                            <div>
                                <input type="date" v-model="date" name="start_date" required>
                                <input type="text" v-model="time" name="start_time" placeholder="00:00" size="5" required>～
                                <p class="help" v-if="isTime">時間は「0:00 ~ 23:59」の間で設定してください</p>
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
                                            <input type="text" v-model="name" name="name" required>
                                        </div>
                                    </div>

                                    <div class="level">
                                        <div class="level-left">
                                            開催地：
                                        </div>
                                        <div class="level-right">
                                            <input type="text" v-model="location" name="location" required>
                                        </div>
                                    </div>

                                    <div class="level">
                                        <div class="level-left">
                                            開催地所在地：
                                        </div>
                                        <div class="level-right">
                                            <div>
                                                <div>
                                                    <input type="text" v-model="addressNum" name="post-code" placeholder="000-0000" size="8" required>
                                                    <input type="text" v-model="address" name="address" required>
                                                </div>
                                                <p class="help" v-if="isAddressNum">郵便番号は「xxx-xxxx」形式で入力してください</p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="level">
                                        <div class="level-left">
                                            <div>
                                                <p>主催連絡先（TEL）：</p>
                                                <p class="help">ハイフン不要</p>
                                            </div>
                                        </div>
                                        <div class="level-right">
                                            <div>
                                                <input type="text" v-model="tel" name="tel" required>
                                                <p class="help" v-if="isTel">数字で入力してください</p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="level">
                                        <div class="level-left">
                                            商品の詳細：
                                        </div>
                                        <div class="level-right">
                                            <div>
                                                <textarea v-model="detail" name="detail" cols="25" rows="5" max="1000" placeholder="※1000文字以内で入力してください" required></textarea>
                                                <p class="help">{{ detail.length }}/ 1000 <span v-if="isDetailOver"><font color="red">※文字数が超過しています</font></span> </p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="level">
                                        <div class="level-left">
                                            サムネイル画像：
                                        </div>
                                        <div class="level-right">
                                            <div>
                                                <input type="file" name="file" required>
                                                <?php if(isset($_GET['failed'])) : ?>
                                                    <p class="help"><font color="red">ファイルはpng、またはjpegを指定してください</font></p>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="level">
                                        <div class="level-left">
                                            参加料：
                                        </div>
                                        <div class="level-right">
                                            <input type="number" v-model="price" min="0" size="5" name="price" required>円
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>

                        </div>
                    </div>

                    <hr>

                    <div class="container is-fluid">
                        <div class="level">
                           
                            <button :disabled="isFullInput" class="button is-info level-item">更新
                            </button>

                            <input type="hidden" name="provider_id" value="---提供者ID---">
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/vue@2.7.11/dist/vue.js"></script>
    <script src="script/product-insert-script.js"></script>
    
</div>

<?php require "parts/provider_bottom.php"; ?>
<?php require "parts/footer.php"; ?>
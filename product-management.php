<?php require "parts/header.php"; ?>
<?php require "parts/provider_navigation.php"; ?>

<?php require "parts/db-connect.php"; ?>

<div class="section">
    <div class="box has-background-light" style="border-radius: 20px; ">
        <div class="media">
            <div class="media-left">
                <div style="text-align: left;">
                    <span><span class="title is-h5">商品名</span><button class="button is-small is-light is-rounded" disabled>タグ名</button></span>

                    <div>
                        <p>
                            参加日時：2025年3月20日 15:00~
                        </p>

                        <p>
                            場所：麻生農園
                        </p>

                        <p>
                            所在地：福岡県みやま市高田町
                        </p>

                        <p>
                            参加人数：2/30人
                        </p>

                    </div>
                </div>
            </div>
            <div class="media-content">
                <p class="image is-128x128" style="align-content: center;">
                    <img src="product-img/いちご狩り.png" alt="サムネイル">
                </p>
            </div>
            <div class="media-right">
                <button class="button is-primary is-rounded">予約情報を見る</button>
                <button class="button is-danger is-rounded">商品を削除</button>
            </div>
        </div>
    </div>
</div>

<?php require "parts/provider_bottom.php"; ?>
<?php require "parts/footer.php"; ?>
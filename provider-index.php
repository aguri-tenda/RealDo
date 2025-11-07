<?php require "parts/header.php"; ?>
<?php require "parts/provider_navigation.php"; ?>
<?php require "parts/db-connect.php"; ?>

<div class="columns is-gapless">
    <div class="column is-narrow" style="background-color: #79D159; min-height: 100vh; padding: 0;">
        <aside class="menu" style="padding: 20px; width: 250px;">
            <ul class="menu-list">
                <li>
                    <a href="#" class="is-active" style="background-color: #55B537; color: white;">商品一覧</a>
                </li>
                <li>
                    <a href="productInsert.php" style="color: white;">商品登録</a>
                </li>
                <li>
                    <a href="productManagement.php" style="color: white;">商品管理</a>
                </li>
            </ul>
        </aside>
    </div>

    <div class="column">

    </div>
</div>



<?php require "parts/provider_bottom.php"; ?>
<?php require "parts/footer.php"; ?>
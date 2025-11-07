<?php require "parts/header.php"; ?>
<?php require "parts/provider_navigation.php"; ?>
<br><br><br>
<div class="level-item">
    <form class="box" style="width: 520px; text-align: center;" action="provider-logout-action.php" method="post">
        <span class="subtitle is-4" style="color:#278EDD;">ログアウト確認</span>
        <br><br><br>

        <p style="color:#278EDD; font-size: 18px;">本当にログアウトしますか？</p>

        <div class="field has-text-centered" style="margin-top: 2rem;">
            <a href="provider-index.php" class="button is-light is-medium" style="margin-right: 20px;">戻る</a>
            <input class="button is-link is-medium" type="submit" value="ログアウト"
                style="background-color: #C3FF9B; width: 40%;">
        </div>
    </form>
</div>
<?php require "parts/provider_bottom.php"; ?>
<?php require "parts/footer.php"; ?>
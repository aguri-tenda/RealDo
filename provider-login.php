<?php require "parts/header.php"; ?>
<?php require "parts/provider_navigation.php"; ?>
<br>
<div class="level-item">
    <form class="box" style="max-width: 700px; width: 100%; text-align: center;" action="provider-login-action.php" method="post">
        <h2 class="subtitle is-4" style="color: #27ea6bff;">ログイン</h2>
        <br><br><br>

        <!-- ユーザーID -->
        <div class="field is-horizontal">
            <div class="field-label is-normal">
                <label style="color: #27ea6bff;">ユーザーID</label>
            </div>
            <div class="field-body">
                <div class="field">
                    <div class="control">
                        <input class="input" type="text" name="userid" required placeholder="ユーザーIDを入力"
                            style="background-color: #D9D9D9; border: 1px solid #858484; width: 90%;">
                    </div>
                </div>
            </div>
        </div>

        <!-- パスワード -->
        <div class="field is-horizontal">
            <div class="field-label is-normal">
                <label style="color: #27ea6bff;">パスワード</label>
            </div>
            <div class="field-body">
                <div class="field">
                    <div class="control">
                        <input class="input" type="password" name="password" required placeholder="パスワードを入力"
                            style="background-color: #D9D9D9; border: 1px solid #858484; width: 90%;">
                    </div>
                </div>
            </div>
        </div>

        <!-- ボタン -->
        <div class="field has-text-centered" style="margin-top: 2rem;">
            <button class="button is-info" style="background-color: #27ea6bff; width: 225px; border-radius: 5px;">
                確定
            </button>
        </div>
    </form>
</div>
<br>
<div class="field has-text-centered">
    <a href="provider-login.php" class="button is-info is-medium"
        style="background-color: #41C0FF; width: 250px;">ユーザーログイン</a>
</div>

<?php require "parts/provider_bottom.php"; ?>
<?php require "parts/footer.php"; ?>
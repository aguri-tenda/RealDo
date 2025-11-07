<?php require "parts/header.php"; ?>
<?php require "parts/navigation.php"; ?>
<br>
<div class="level-item">
    <form class="box" style="width: 520px; text-align: center;" action="user-login-output.php" method="post">
        <h2 class="subtitle is-4" style="color: #278EDD;">ログイン</h2>
        <br><br><br>

        <!-- ユーザーID -->
        <div class="field is-horizontal">
            <div class="field-label is-normal">
                <label style="color: #278EDD;">ユーザーID</label>
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
                <label style="color: #278EDD;">パスワード</label>
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
            <button class="button is-info" style="background-color: #41C0FF; width: 225px; border-radius: 5px;">
                確定
            </button>
        </div>
    </form>
</div>

<?php require "parts/user_bottom.php"; ?>
<?php require "parts/footer.php"; ?>
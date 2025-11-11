<?php require "parts/header.php"; ?>
<?php require "parts/provider_navigation.php"; ?>
<?php require "parts/db-connect.php"; ?>

<?php
// 入力データを受け取る
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $_SESSION['provider_update'] = [ // 登録用のセッションにデータを保存
        'name' => $_POST['providername'] ?? '',
        'user_id' => $_POST['providerid'] ?? '',
        'address' => $_POST['provideraddress'] ?? '',
        'oldpassword' => $_POST['oldpassword'] ?? '',
        'password' => $_POST['providerpassword'] ?? '',
    ];
}

// セッションから表示用のデータを取得
$name = $_SESSION['provider_update']['name'] ?? '';
$user_id = $_SESSION['provider_update']['user_id'] ?? '';
$address = $_SESSION['provider_update']['address'] ?? '';
$oldpassword = $_SESSION['provider_update']['oldpassword'] ?? '';
$password = $_SESSION['provider_update']['password'] ?? '';
?>


<div class="level-item">
    <form class="box" style="width: 520px; text-align: center;" action="providerUpdate_action.php" method="post">
        <span class="subtitle is-4" style="color:#278EDD;">登録内容確認</span>
        <br><br><br>

        <!-- ユーザー名 -->
        <div class="field is-horizontal">
            <div class="field-label is-normal">
                <label style="color:#278EDD;">ユーザー名</label>
            </div>
            <div class="field-body">
                <div class="field">
                    <div class="control">
                        <input disabled class="input" type="text" value="<?php echo htmlspecialchars($name); ?>"
                            style="background-color:#E3FFFF;width:80%;border:1px solid #858484ff;">
                    </div>
                </div>
            </div>
        </div>

        <!-- ユーザーID -->
        <div class="field is-horizontal">
            <div class="field-label is-normal">
                <label style="color:#278EDD;">ユーザーID</label>
            </div>
            <div class="field-body">
                <div class="field">
                    <div class="control">
                        <input disabled class="input" type="text" value="<?php echo htmlspecialchars($user_id); ?>"
                            style="background-color:#E3FFFF;width:80%;border:1px solid #858484ff;">
                    </div>
                </div>
            </div>
        </div>

        <!-- メールアドレス -->
        <div class="field is-horizontal">
            <div class="field-label is-normal">
                <label style="color:#278EDD;">メールアドレス</label>
            </div>
            <div class="field-body">
                <div class="field">
                    <div class="control">
                        <input disabled class="input" type="email" value="<?php echo htmlspecialchars($address); ?>"
                            style="background-color:#E3FFFF;width:80%;border:1px solid #858484ff;">
                    </div>
                </div>
            </div>
        </div>

        <!-- パスワード -->
        <div class="field is-horizontal">
            <div class="field-label is-normal">
                <label style="color:#278EDD;">パスワード</label>
            </div>
            <div class="field-body">
                <div class="field">
                    <div class="control">
                        <input disabled class="input" type="password" value="<?php echo htmlspecialchars($password); ?>"
                            style="background-color:#E3FFFF;width:80%;border:1px solid #858484ff;">
                    </div>
                </div>
            </div>
        </div>

        <!-- ボタン -->
        <div class="field has-text-centered" style="margin-top: 2rem;">
            <a href="providerUpdate.php" class="button is-light is-medium" style="margin-right: 20px;">戻る</a>
            <input class="button is-link is-medium" type="submit" value="登録する"
                style="background-color: #41C0FF; width: 40%;">
        </div>
    </form>
</div>

<?php require "parts/provider_bottom.php"; ?>
<?php require "parts/footer.php"; ?>
<?php require "parts/header.php"; ?>
<?php require "parts/provider_navigation.php"; ?>
<?php
// 入力データを受け取り、セッションに保存
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $_SESSION['provider'] = [
        'providername' => $_POST['providername'] ?? '',
        'providerid' => $_POST['providerid'] ?? '',
        'provideraddress' => $_POST['provideraddress'] ?? '',
        'providerpassword' => $_POST['providerpassword'] ?? '',
    ];
}
?>

<body style="background-color:#EBEBEB">
    <br>
    <div class="level-item">
        <form class="box" style="width: 520px; text-align: center;" action="provider-index.php" method="post">
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
                            <input disabled class="input" type="text"
                                value="<?php echo htmlspecialchars($provider_name); ?>"
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
                            <input disabled class="input" type="text"
                                value="<?php echo htmlspecialchars($provider_id); ?>"
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
                            <input disabled class="input" type="email"
                                value="<?php echo htmlspecialchars($provider_address); ?>"
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
                            <input disabled class="input" type="password"
                                value="<?php echo htmlspecialchars($provider_password); ?>"
                                style="background-color:#E3FFFF;width:80%;border:1px solid #858484ff;">
                        </div>
                    </div>
                </div>
            </div>

            <!-- hidden でデータを送る -->
            <input type="hidden" name="providername" value="<?php echo htmlspecialchars($provider_name); ?>">
            <input type="hidden" name="providerid" value="<?php echo htmlspecialchars($provider_id); ?>">
            <input type="hidden" name="provideraddress" value="<?php echo htmlspecialchars($provider_address); ?>">
            <input type="hidden" name="providerpassword" value="<?php echo htmlspecialchars($provider_password); ?>">

            <!-- ボタン -->
            <div class="field has-text-centered" style="margin-top: 2rem;">
                <a href="providerInsert.php" class="button is-light is-medium" style="margin-right: 20px;">戻る</a>
                <input class="button is-link is-medium" type="submit" value="登録する"
                    style="background-color: #41C0FF; width: 40%;">
            </div>
        </form>
    </div>
</body>

<?php require "parts/provider_bottom.php"; ?>
<?php require "parts/footer.php"; ?>
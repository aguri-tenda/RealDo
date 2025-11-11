<?php require "parts/header.php"; ?>
<?php require "parts/provider_navigation.php"; ?>

<body style="background-color:#EBEBEB">
    <br>
    <div class="level-item">
        <?php
        // 戻ってきた場合のエラーメッセージ
        if (isset($_GET['wrong_id']) && $_GET['wrong_id'] == 1) {
            echo '<p style="color: red; font-weight: bold;">そのユーザーIDは既に使用されています。</p><br>';
        }
        ?>
        <form class="box" style="max-width: 700px; width: 100%; text-align: center;"
            action="providerInsert_complete.php" method="post">
            <span class="subtitle is-4" style="color:#27ea6bff;">新規登録</span>
            <br><br><br>

            <div class="field is-horizontal" style="margin-bottom: 1rem;">
                <div class="field-label is-normal">
                    <label style="color:#27ea6bff;">ユーザー名</label>
                </div>
                <div class="field-body">
                    <div class="field">
                        <div class="control">
                            <input class="input" type="text" name="providername" placeholder="例）田中太郎"
                                style="background-color: #D9D9D9; width: 90%; border: 1px solid #858484ff;">
                        </div>
                    </div>
                </div>
            </div>

            <!-- ユーザーID -->
            <div class="field is-horizontal" style="margin-bottom: 1rem;">
                <div class="field-label is-normal">
                    <label style="color:#27ea6bff;">ユーザーID</label>
                </div>
                <div class="field-body">
                    <div class="field">
                        <div class="control">
                            <input class="input" type="text" name="providerid" placeholder="例）taro123"
                                style="background-color: #D9D9D9; width: 90%; border: 1px solid #858484ff;">
                        </div>
                    </div>
                </div>
            </div>

            <!-- メールアドレス -->
            <div class="field is-horizontal" style="margin-bottom: 1rem;">
                <div class="field-label is-normal">
                    <label style="color:#27ea6bff;">メールアドレス</label>
                </div>
                <div class="field-body">
                    <div class="field">
                        <div class="control">
                            <input class="input" type="email" name="provideraddress" placeholder="example@example.com"
                                style="background-color: #D9D9D9; width: 90%; border: 1px solid #858484ff;">
                        </div>
                    </div>
                </div>
            </div>

            <!-- パスワード -->
            <div class="field is-horizontal" style="margin-bottom: 2rem;">
                <div class="field-label is-normal">
                    <label style="color:#27ea6bff;">パスワード</label>
                </div>
                <div class="field-body">
                    <div class="field">
                        <div class="control">
                            <input class="input" type="password" name="providerpassword" placeholder="8文字以上"
                                style="background-color: #D9D9D9; width: 90%; border: 1px solid #858484ff;">
                        </div>
                    </div>
                </div>
            </div>

            <!-- ボタン -->
            <div class="field has-text-centered">
                <input class="button is-info is-medium" type="submit" value="確定"
                    style="background-color: #27ea6bff; width: 300px;">
            </div>

        </form>
    </div>
    <br>
    <div class="field has-text-centered">
        <a href="userInsert.php" class="button is-info is-medium"
            style="background-color: #23c8ffff; width: 250px;">利用者新規登録</a>
    </div>
</body>
<?php require "parts/provider_bottom.php"; ?>
<?php require "parts/footer.php"; ?>
<?php require "parts/header.php"; ?>
<?php require "parts/provider_navigation.php"; ?>
<br>

<body style="background-color:#EBEBEB;padding-bottom: 150px;">
    <div class="level-item">
        <form class="box" style="max-width: 700px; width: 100%; text-align: center;"
            action="providerInsert_complete.php" method="post">
            <span class="subtitle is-4" style="color:#278EDD;">情報更新</span>
            <br><br><br>

            <!-- ユーザー名 -->
            <div class="field is-horizontal" style="margin-bottom: 1rem;">
                <div class="field-label is-normal">
                    <label style="color:#278EDD;">ユーザー名</label>
                </div>
                <div class="field-body">
                    <div class="field">
                        <div class="control">
                            <input class="input" type="text" name="providername" value="<?= $provider_name ?>"
                                style="background-color: #D9D9D9; width: 90%; border: 1px solid #858484ff;">
                        </div>
                    </div>
                </div>
            </div>

            <!-- ユーザーID -->
            <div class="field is-horizontal" style="margin-bottom: 1rem;">
                <div class="field-label is-normal">
                    <label style="color:#278EDD;">ユーザーID</label>
                </div>
                <div class="field-body">
                    <div class="field">
                        <div class="control">
                            <input class="input" type="text" name="providerid" value="<?= $provider_id ?>"
                                style="background-color: #D9D9D9; width: 90%; border: 1px solid #858484ff;">
                        </div>
                    </div>
                </div>
            </div>

            <!-- メールアドレス -->
            <div class="field is-horizontal" style="margin-bottom: 1rem;">
                <div class="field-label is-normal">
                    <label style="color:#278EDD;">メールアドレス</label>
                </div>
                <div class="field-body">
                    <div class="field">
                        <div class="control">
                            <input class="input" type="email" name="provideraddress" value="<?= $provider_address ?>"
                                style="background-color: #D9D9D9; width: 90%; border: 1px solid #858484ff;">
                        </div>
                    </div>
                </div>
            </div>

            <!-- パスワード -->
            <div class="field is-horizontal" style="margin-bottom: 2rem;">
                <div class="field-label is-normal">
                    <label style="color:#278EDD;">パスワード</label>
                </div>
                <div class="field-body">
                    <div class="field">
                        <div class="control">
                            <input class="input" type="password" name="providerpassword"
                                value="<?= $provider_password ?>"
                                style="background-color: #D9D9D9; width: 90%; border: 1px solid #858484ff;">
                        </div>
                    </div>
                </div>
            </div>

            <!-- ボタン -->
            <div class="field has-text-centered">
                <input class="button is-info is-medium" type="submit" value="確定"
                    style="background-color: #41C0FF; width: 300px;">
            </div>

        </form>
    </div>
</body>

<?php require "parts/provider_bottom.php"; ?>
<?php require "parts/footer.php"; ?>
<?php session_start(); ?>
<?php require 'parts/db-connect.php'; ?>
<?php
// 古いパスワードが正しければ、providerUpdate_complete.phpへリダイレクトする
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $provider_id = $_SESSION['provider']['providerid'] ?? '';
    $oldpassword = $_POST['oldpassword'] ?? '';
    $sql = $pdo->prepare("SELECT * FROM providers WHERE provider_id = ?");
    $sql->execute([$provider_id]);
    $provider = $sql->fetch();
    if ($provider && password_verify($oldpassword, $provider['password'])) {
        // パスワードが正しい場合、更新内容をセッションに保存して確認ページへリダイレクト
        $_SESSION['provider_update'] = [
            'providername' => $_POST['providername'] ?? '',
            'providerid' => $provider_id,
            'provideraddress' => $_POST['provideraddress'] ?? '',
            'oldpassword' => $oldpassword,
            'password' => $_POST['providerpassword'] ?? '',
        ];
        header('Location: providerUpdate_complete.php');
        exit;
    } else {
        // パスワードが間違っている場合、エラーメッセージを表示
        $error_message = "古いパスワードが正しくありません。";
    }
}
?>

<?php require "parts/header.php"; ?>
<?php require "parts/provider_navigation.php"; ?>

<div class="level-item">
    <form class="box" style="max-width: 700px; width: 100%; text-align: center;" action="providerUpdate.php"
        method="post">
        <?php if (isset($error_message)): ?>
            <p class="has-text-danger" style="margin-bottom: 1rem; font-weight: bold;">
                <?= htmlspecialchars($error_message) ?>
            </p>
        <?php endif; ?>
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
                            required style="background-color: #D9D9D9; width: 90%; border: 1px solid #858484ff;">
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
                            required style="background-color: #D9D9D9; width: 90%; border: 1px solid #858484ff;">
                    </div>
                </div>
            </div>
        </div>

        <!-- 古いパスワード -->
        <div class="field is-horizontal" style="margin-bottom: 2rem;">
            <div class="field-label is-normal">
                <label style="color:#278EDD;">古いパスワード</label>
            </div>
            <div class="field-body">
                <div class="field">
                    <div class="control">
                        <input class="input" type="password" name="oldpassword" required
                            style="background-color: #D9D9D9; width: 90%; border: 1px solid #858484ff;">
                    </div>
                </div>
            </div>
        </div>

        <!-- パスワード -->
        <div class="field is-horizontal" style="margin-bottom: 2rem;">
            <div class="field-label is-normal">
                <label style="color:#278EDD;">新しいパスワード</label>
            </div>
            <div class="field-body">
                <div class="field">
                    <div class="control">
                        <input class="input" type="password" name="providerpassword" required
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

<?php require "parts/provider_bottom.php"; ?>
<?php require "parts/footer.php"; ?>
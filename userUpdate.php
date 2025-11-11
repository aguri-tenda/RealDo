<?php require 'parts/db-connect.php'; ?>
<?php
// 古いパスワードが正しければ、userUpdate_complete.phpへリダイレクトする
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user']['userid'] ?? '';
    $oldpassword = $_POST['oldpassword'] ?? '';
    $sql = $pdo->prepare("SELECT * FROM users WHERE user_id = ?");
    $sql->execute([$user_id]);
    $user = $sql->fetch();
    if ($user && password_verify($oldpassword, $user['password'])) {
        // パスワードが正しい場合、更新内容をセッションに保存して確認ページへリダイレクト
        session_start();
        $_SESSION['user_update'] = [
            'name' => $_POST['username'] ?? '',
            'user_id' => $user_id,
            'address' => $_POST['useraddress'] ?? '',
            'oldpassword' => $oldpassword,
            'password' => $_POST['userpassword'] ?? '',
        ];
        header('Location: userUpdate_complete.php');
        exit;
    } else {
        // パスワードが間違っている場合、エラーメッセージを表示
        $error_message = "古いパスワードが正しくありません。";
    }
}
?>
<?php require "parts/header.php"; ?>
<?php require "parts/navigation.php"; ?>


<div class="level-item">
    <form class="box" style="max-width: 700px; width: 100%; text-align: center;" action="userUpdate.php"
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
                        <input class="input" type="text" name="username" value="<?= $name ?>"
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
                        <input class="input" type="text" name="userid" value="<?= $user_id ?>"
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
                        <input class="input" type="email" name="useraddress" value="<?= $address ?>"
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
                        <input class="input" type="password" name="userpassword" required
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

<?php require "parts/user_bottom.php"; ?>
<?php require "parts/footer.php"; ?>
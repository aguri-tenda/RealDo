<?php session_start(); ?>
<?php require "parts/db-connect.php"; ?>

<?php
// 入力データを受け取る
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $_SESSION['user_update'] = [ // 登録用のセッションにデータを保存
        'name' => $_POST['username'] ?? '',
        'user_id' => $_POST['userid'] ?? '',
        'address' => $_POST['useraddress'] ?? '',
        'oldpassword' => $_POST['oldpassword'] ?? '',
        'password' => $_POST['userpassword'] ?? '',
    ];
}

// セッションから表示用のデータを取得
$name = $_SESSION['user_update']['name'] ?? '';
$user_id = $_SESSION['user_update']['user_id'] ?? '';
$address = $_SESSION['user_update']['address'] ?? '';
$oldpassword = $_SESSION['user_update']['oldpassword'] ?? '';
$password = $_SESSION['user_update']['password'] ?? '';

//ユーザーIDが重複している場合、入力フォームに戻る
$sql = "SELECT COUNT(*) as count FROM users WHERE user_id = ? AND user_id != ?";
$sql = $pdo->prepare($sql);
$sql->execute([$user_id, $_SESSION['user']['user_id']]);
$result = $sql->fetch(PDO::FETCH_ASSOC);
if ($result['count'] > 0) {
    header("Location: userUpdate.php?wrong_id=1");
    exit();
}

//古いパスワードが間違っている場合、入力フォームに戻る
$sql = "SELECT password FROM users WHERE user_id = ?";
$sql = $pdo->prepare($sql);
$sql->execute([$_SESSION['user']['user_id']]);
$hasshed_password = $sql->fetchColumn();
if (!password_verify($oldpassword, $hasshed_password)) {
    header("Location: userUpdate.php?wrong_id=2");
    exit();
}
?>

<?php require "parts/header.php"; ?>
<?php require "parts/navigation.php"; ?>

<div class="level-item">
    <form class="box" style="width: 520px; text-align: center;" action="userUpdate-action.php" method="post">
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

        <!-- hidden でデータを送る -->
        <input type="hidden" name="username" value="<?php echo htmlspecialchars($name); ?>">
        <input type="hidden" name="userid" value="<?php echo htmlspecialchars($user_id); ?>">
        <input type="hidden" name="useraddress" value="<?php echo htmlspecialchars($address); ?>">
        <input type="hidden" name="userpassword" value="<?php echo htmlspecialchars($password); ?>">

        <!-- ボタン -->
        <div class="field has-text-centered" style="margin-top: 2rem;">
            <a href="userUpdate.php" class="button is-light is-medium" style="margin-right: 20px;">戻る</a>
            <input class="button is-link is-medium" type="submit" value="登録する"
                style="background-color: #41C0FF; width: 40%;">
        </div>
    </form>
</div>

<?php require "parts/user_bottom.php"; ?>
<?php require "parts/footer.php"; ?>
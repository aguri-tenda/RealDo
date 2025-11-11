<?php require "parts/header.php"; ?>
<?php require "parts/navigation.php"; ?>
<?php require 'parts/db-connect.php'; ?>

<?php
$userid = $_POST['userid'];
$password = $_POST['password'];
$sql = $pdo->prepare("SELECT * FROM users WHERE user_id = ? AND is_active = 1");
$sql->execute([$userid]);
$user = $sql->fetch(PDO::FETCH_ASSOC);
if ($user && password_verify($password, $user['password'])) {
    // ログイン成功
    $_SESSION['user'] = [
        'username' => $user['name'],
        'userid' => $user['user_id'],
        'useraddress' => $user['mail']
    ];
    $login_message = "ログイン成功！ようこそ、" . htmlspecialchars($user['name']) . "さん。";
} else {
    // ログイン失敗
    $login_message = "ユーザーIDまたはパスワードが間違っています。";
}
echo '<br><div class="level-item"><div class="box" style="max-width: 700px; width: 100%; text-align: center;">';
echo '<h2 class="subtitle is-4" style="color: #278EDD;">ログイン結果</h2><br><br><br>';
echo '<p>' . htmlspecialchars($login_message) . '</p>';
echo '</div></div>';
echo '<div class="field has-text-centered" style="margin-top: 20px; margin-bottom: 40px;">
<a href="index.php" class="button is-info is-medium"
    style="background-color: #278EDD; width: 250px;">ホーム画面へ</a>
</div>';
?>

<?php require "parts/user_bottom.php"; ?>
<?php require "parts/footer.php"; ?>
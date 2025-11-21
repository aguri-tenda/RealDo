<?php
require "parts/header.php";
require "parts/navigation.php";
require "parts/db-connect.php";

$product_id = $_GET['product_id'] ?? null;
if ($product_id === null) {
    echo "<p>Product ID is missing.</p>";
    exit;
}

$sql = $pdo->prepare("SELECT * FROM products WHERE product_id = ?");
$sql->execute([$product_id]);
$product = $sql->fetch(PDO::FETCH_ASSOC);
if (!$product) {
    echo "<p>Product not found.</p>";
    exit;
}

$dates_sql = $pdo->prepare("SELECT * FROM dates WHERE product_id = ? ORDER BY start_time ASC");
$dates_sql->execute([$product_id]);
$dates = $dates_sql->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container">
    <h1 class="title is-3 has-text-centered">予約フォーム</h1>

    <form method="post" action="booking_participants.php">
        <input type="hidden" name="product_id" value="<?= htmlspecialchars($product['product_id']) ?>">
        <!-- 参加人数 -->
        <div class="field">
            <label class="label">参加人数</label>
            <div class="control">
                <input class="input" type="number" name="people" value="1" min="1">
            </div>
        </div>

        <!-- 参加日時 -->
        <div class="field">
            <label class="label">参加日時</label>
            <div class="control">
                <div class="select">
                    <select name="date_id">
                        <?php foreach ($dates as $date): ?>
                            <option value="<?= htmlspecialchars($date['start_time']) ?>">
                                <?= htmlspecialchars(date('Y-m-d H:i', strtotime($date['start_time']))) ?> 〜 <?= htmlspecialchars(date('Y-m-d H:i', strtotime($date['finish_time']))) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
        </div>

        <!-- 緊急連絡先 -->
        <div class="field">
            <label class="label">緊急連絡先</label>
            <div class="control">
                <input class="input" type="text" name="tel" placeholder="例：090-1234-5678">
            </div>
        </div>

        <!--備考-->
        <div class="field">
            <label class="label">備考</label>
            <div class="control">
                <textarea class="textarea" name="remark" placeholder="アレルギー情報や特別な配慮が必要な事項などがあればご記入ください。"></textarea>
            </div>
        </div>

        <!-- 参加者情報 -->
        <!-- <div class="field">
            <label class="label">参加者情報</label>

            <div class="control mb-2">
                <input class="input" type="text" name="last_name" placeholder="姓（例：田中）">
            </div>

            <div class="control mb-2">
                <input class="input" type="text" name="kana_last" placeholder="フリガナ（例：タナカ）">
            </div>

            <div class="control mb-2">
                <input class="input" type="text" name="first_name" placeholder="名（例：太郎）">
            </div>

            <div class="control mb-2">
                <input class="input" type="text" name="kana_first" placeholder="フリガナ（例：タロウ）">
            </div>

            <div class="control">
                <input class="input" type="text" name="tel" placeholder="電話番号（例：000-0000-0000）">
            </div>
        </div> -->

        <!-- ボタン -->
        <div class="field has-text-centered">
            <button class="button is-info is-medium" type="submit">確定</button>
        </div>
    </form>
</div>

<?php
require "parts/user_bottom.php";
require "parts/footer.php";
?>
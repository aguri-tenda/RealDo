<?php require "parts/header.php"; ?>
<?php require "parts/navigation.php"; ?>

<?php
$product_id = $_GET['product_id'] ?? '';
$sql = $pdo->prepare("SELECT * FROM products WHERE product_id = ?");
$sql->execute([$product_id]);
$product = $sql->fetch(PDO::FETCH_ASSOC);

$_SESSION['review'] = [
    'product_id' => $product_id,
    'reviewtext' => $_GET['reviewtext'] ?? '',
    'rating' => $_GET['rating'] ?? 0,
];

if (!$product) {
    echo "<p>Product not found.</p>";
    exit;
}

$is_purchased = false;
$is_past_purchase = false;
if (isset($_SESSION['user'])) {
    $purchase_sql = $pdo->prepare(
        "SELECT COUNT(*) FROM purchases 
        WHERE user_id = ? AND product_id = ?"
    );
    $purchase_sql->execute([$user_id, $product_id]);
    $purchase_count = $purchase_sql->fetchColumn();
    if ($purchase_count > 0) {
        $is_purchased = true;
    }
    $time_sql = $pdo->prepare(
        "SELECT start_time FROM purchases
        WHERE user_id = ? AND product_id = ?"
    );
    $time_sql->execute([$user_id, $product_id]);
    $purchase_times = $time_sql->fetchAll(PDO::FETCH_COLUMN);
    $current_time = date('Y-m-d H:i:s');
    foreach ($purchase_times as $start_time) {
        if ($start_time < $current_time) {
            $is_past_purchase = true;
            break;
        }
    }
    if (!$is_past_purchase) {
        echo "<div class=\"box\" style=\"width: 520px; text-align: center; margin: 2rem auto;\">";
        echo "<p>この商品をまだ体験していないため、レビューを投稿できません。</p>";
        echo '<a href="detail.php?product_id=' . htmlspecialchars($product_id) . '" class="button is-link" style="background-color: #41C0FF; margin-top: 15px;">戻る</a>';
        echo "</div>";
        exit;
    }
}
if (!$is_purchased) {
    echo "<div class=\"box\" style=\"width: 520px; text-align: center; margin: 2rem auto;\">";
    echo "<p>この商品を購入していないため、レビューを投稿できません。</p>";
    echo '<a href="detail.php?product_id=' . htmlspecialchars($product_id) . '" class="button is-link" style="background-color: #41C0FF; margin-top: 15px;">戻る</a>';
    echo "</div>";
    exit;
}

$review_sql = $pdo->prepare(
    "SELECT COUNT(*) FROM reviews 
    WHERE user_id = ? AND product_id = ?"
);
$review_sql->execute([$user_id, $product_id]);
$review_count = $review_sql->fetchColumn();
if ($review_count > 0) {
    echo "<div class=\"box\" style=\"width: 520px; text-align: center; margin: 2rem auto;\">";
    echo "<p>この商品には既にレビューを投稿しています。</p>";
    echo '<a href="detail.php?product_id=' . htmlspecialchars($product_id) . '" class="button is-link" style="background-color: #41C0FF; margin-top: 15px;">戻る</a>';
    echo "</div>";
    exit;
}
?>

<br>

<?php if (isset($_SESSION['user'])): ?>

<div class="level">
    <a href="detail.php?product_id=<?= $product_id; ?>"><input type="button" class="button is-link level-left ml-3" value="戻る"></a>
</div>

<div class="level-item">
    <form class="box" style="width: 520px; text-align: center;" action="review_complete.php" method="post">
        <span class="subtitle is-4" style="color:#278EDD;">レビュー投稿</span>
        <div class="field is-horizontal" style="margin-top: 2rem;">
            <div class="field-label is-medium">
                <label class="label" style="color:#278EDD;">評価</label>
            </div>
            <div class="field-body">
                <div class="field">
                    <div id="vue-rating-app">
                        <rating-selector rating=<?php echo htmlspecialchars($_SESSION['review']['rating'] ?? 0); ?>></rating-selector>
                    </div>
                    <input type="hidden" name="rating" id="rating-value" value=<?php echo htmlspecialchars($_SESSION['review']['rating'] ?? 0); ?>>
                </div>
            </div>
        </div>

        <div class="field is-horizontal" style="margin-top: 1.5rem;">
            <div class="field-label is-medium">
                <label class="label" style="color:#278EDD;">レビュー内容</label>
            </div>
            <div class="field-body">
                <div class="field">
                    <div class="control">
                        <textarea class="textarea" rows="4" type="text" name="reviewtext" 
                            style="background-color: #fff; resize: none;"><?php echo htmlspecialchars($_SESSION['review']['reviewtext'] ?? ''); ?></textarea>
                    </div>
                </div>
            </div>
        </div>

        <div class="field has-text-centered" style="margin-top: 3rem;">
            <input class="button is-info" type="submit" value="確定" style="background-color: #41C0FF; width: 300px;">
        </div>

    </form>
</div>
<?php else: ?>
    <div class="box" style="width: 520px; text-align: center; margin: 2rem auto;">
        <p>レビューを投稿するにはログインが必要です。</p>
        <a href="login.php" class="button is-link" style="background-color: #41C0FF; margin-top: 15px;">ログインページへ</a>
    </div>
<?php endif; ?>

<script src="https://cdn.jsdelivr.net/npm/vue@2.7.11/dist/vue.js"></script>
<script src="script/review_insert-script.js"></script>

<?php require "parts/user_bottom.php"; ?>
<?php require "parts/footer.php"; ?>
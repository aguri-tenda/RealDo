<?php require "parts/header.php"; ?>
<?php require "parts/navigation.php"; ?>

<?php require "parts/count_members.php"; ?>

<?php
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

$tags_sql = $pdo->prepare(
    "SELECT t.name, t.tag_id
    FROM attached_tags att
    INNER JOIN tags t
        ON att.tag_id = t.tag_id
    WHERE att.product_id = ?"
);
$tags_sql->execute([$product_id]);
$tags = $tags_sql->fetchAll(PDO::FETCH_ASSOC);

$dates_sql = $pdo->prepare("SELECT * FROM dates WHERE product_id = ? ORDER BY start_time ASC");
$dates_sql->execute([$product_id]);
$dates = $dates_sql->fetchAll(PDO::FETCH_ASSOC);

$reviews_sql = $pdo->prepare(
    "SELECT r.rating, r.text, r.date, u.name
    FROM reviews r
    INNER JOIN users u
        ON r.user_id = u.user_id
    WHERE r.product_id = ?"
);
$reviews_sql->execute([$product_id]);
$reviews = $reviews_sql->fetchAll(PDO::FETCH_ASSOC);

if (count($reviews) > 0) {
    $total_rating = 0;
    foreach ($reviews as $review) {
        $total_rating += $review['rating'];
    }
    $rating_avg = $total_rating / count($reviews);
}

//dbのタグカウントを増やす
$viewWeight = 1; // 閲覧の重み付け（必要に応じて調整可能）
foreach ($tags as $tag) {
    $tag_count_sql = $pdo->prepare("
        INSERT INTO tag_count (user_id, tag_id, attention_level)
        VALUES (:user_id, :tag_id, :attention_level)
        ON DUPLICATE KEY UPDATE attention_level = attention_level + :attention_level
    ");
    $tag_count_sql->execute([
        ':user_id' => $user_id,
        ':tag_id' => $tag['tag_id'],
        ':attention_level' => $viewWeight,
    ]);
}
?>


<div class="container has-text-centered" style="margin-top: 2rem; margin-bottom: 2rem;">
    <div class="field is-horizontal is-justify-content-center mt-5">
        <figure class="image is-128">
            <img src="<?= htmlspecialchars($product['image_pass']) ?>" alt="<?= htmlspecialchars($product['name']) ?>">
        </figure>
    </div>

    <div class="box" style="margin: 25px; display: flex; flex-wrap: wrap; gap: 20px;">
        <!-- 左側: 商品情報 -->
        <div style="flex: 1; min-width: 250px;">
            <figure class="image is-128">
                <img src="<?= htmlspecialchars($product['image_pass']) ?>"
                    alt="<?= htmlspecialchars($product['name']) ?>">
            </figure>

            <p class="tags" style="margin-top: 1rem;">
                <span class="title is-3"><?= htmlspecialchars($product['name']) ?></span>
                <?php foreach ($tags as $tag): ?>
                    <span class="tag is-primary is-light"><?= htmlspecialchars($tag['name']) ?></span>
                <?php endforeach; ?>
            </p>
            <div>
                <p><?= nl2br(htmlspecialchars($product['detail'])) ?></p>
                <p><strong>場所:</strong> <?= htmlspecialchars($product['location']) ?></p>
                <p><strong>所在地:</strong> <?= htmlspecialchars($product['address']) ?></p>
                <p><strong>参加人数:</strong>
                    <?= countMembers($pdo, $product_id) ?>/<?= htmlspecialchars($product['max_participants']) ?>人
                </p>
            </div>
        </div>

        <!-- 右側: 価格と予約ボタン -->
        <div style="flex-basis: 200px; display: flex; flex-direction: column; gap: 10px; align-items: flex-start;">
            <span class="title is-4" style="color:#339ef0;">￥<?= htmlspecialchars($product['price']) ?></span>
            <a href="booking.php?product_id=<?= htmlspecialchars($product['product_id']) ?>" class="button is-info"
                style="background-color:#339ef0ff; color: white;">
                予約
            </a>
        </div>
    </div>


    <div class="box" style="margin: 25px;">
        <h2 class="title is-4">開催日程</h2>
        <?php if (count($dates) === 0): ?>
            <p>現在、開催予定の日程はありません。</p>
        <?php else: ?>
            <table class="table is-fullwidth is-striped">
                <thead>
                    <tr>
                        <th>開始日時</th>
                        <th>終了日時</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($dates as $date): ?>
                        <tr>
                            <td><?= htmlspecialchars($date['start_time']) ?></td>
                            <td><?= htmlspecialchars($date['finish_time']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>

    <form method="post" action="review_insert.php?product_id=<?= htmlspecialchars($product['product_id']) ?>"
        class="box" style="margin: 25px;">
        <h2 class="title is-4">レビュー一覧</h2>
        <?php if (count($reviews) === 0): ?>
            <p>まだレビューはありません。</p>
        <?php else: ?>

            <div class="field is-horizontal column" style="margin-top: 2rem;">
                <div class="field-label is-medium">
                    <label class="label" style="color:#278EDD;">みんなの評価</label>
                </div>
                <div class="field-body">
                    <div class="field">
                        <div id="vue-rating-app">
                            <rating-selector rating=<?= htmlspecialchars($rating_avg) ?> disabled="true"></rating-selector>
                        </div>
                        <input type="hidden" name="rating" id="rating-value" value=<?= htmlspecialchars($rating_avg) ?>; ?>
                    </div>
                </div>
            </div>


            <?php $count = 0; ?>
            <div class="columns is-multiline">
                <?php foreach ($reviews as $review): ?>
                    <?php if ($count >= 5)
                        break; ?>
                    <?php $count++; ?>
                    <div class="card column" style="margin-bottom: 15px; background-color: #d2ffcdff; width: 100%;">
                        <p><strong><?= htmlspecialchars($review['name']) ?></strong> - <?= htmlspecialchars($review['date']) ?>
                        </p>
                        <p>評価: <?= str_repeat('★', $review['rating']) . str_repeat('☆', 5 - $review['rating']) ?></p>
                        <p><?= nl2br(htmlspecialchars($review['text'])) ?></p>
                    </div>
                    <?php if ($count < min(5, count($reviews))): ?>
                        <hr>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        <div class="columns" style="margin-top: 1rem;">
            <button class="button is-info column medium" style="background-color: #339ef0ff; border-radius: 5px;">
                レビューを投稿する
            </button>
        </div>
    </form>
    <?php if (isset($_SESSION['search_params'])): ?>
        <form method="post" action="search.php" class="columns" style="justify-content: center; width: 100%;">
            <input type="hidden" name="searchWord"
                value="<?php echo htmlspecialchars($_SESSION['search_params']['searchWord'] ?? ''); ?>">
            <input type="hidden" name="start_date"
                value="<?php echo htmlspecialchars($_SESSION['search_params']['start_date'] ?? ''); ?>">
            <input type="hidden" name="end_date"
                value="<?php echo htmlspecialchars($_SESSION['search_params']['end_date'] ?? ''); ?>">
            <input type="hidden" name="event_location"
                value="<?php echo htmlspecialchars($_SESSION['search_params']['event_location'] ?? ''); ?>">
            <input type="hidden" name="event_duration"
                value="<?php echo htmlspecialchars($_SESSION['search_params']['event_duration'] ?? ''); ?>">
            <?php
            foreach ($_SESSION['search_params']['tags'] as $tag) {
                echo '<input type="hidden" name="tags[]" value="' . htmlspecialchars($tag) . '">';
            }
            ?>
            <div class="field has-text-centered" style="margin-top: 2rem; margin-bottom: 4rem;">
                <button class="button is-info" style="background-color: #339ef0ff; width: 225px; border-radius: 5px;">
                    検索結果に戻る
                </button>
            </div>
        </form>
    <?php else: ?>
        <div class="field has-text-centered" style="margin: 2rem 0;">
            <a href="index.php" class="button is-info is-medium" style="width: 225px; max-width: 90%; border-radius: 5px;">
                ホームに戻る
            </a>
        </div>
    <?php endif; ?>
</div>

<div class="section">
    <div class="container">
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/vue@2.7.11/dist/vue.js"></script>
<script src="script/review_insert-script.js"></script>

<?php require "parts/user_bottom.php"; ?>
<?php require "parts/footer.php"; ?>
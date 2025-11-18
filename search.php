<?php require "parts/header.php"; ?>
<?php require "parts/navigation.php"; ?>
<?php require "parts/db-connect.php"; ?>

<?php
$searchWord     = $_POST['searchWord']      ?? '';
$selected_tags  = $_POST['tags']            ?? [];
$start_date     = $_POST['start_date']      ?? '';
$end_date       = $_POST['end_date']        ?? '';
$event_location = $_POST['event_location']  ?? '';
$event_duration = $_POST['event_duration']  ?? '';

// ベースSQL
$sql = "
    SELECT
        p.product_id,
        p.name,
        p.location,
        p.detail,
        p.address,
        p.image_pass,
        p.max_participants,
        d.start_time,
        d.finish_time
    FROM products p
    INNER JOIN dates d
        ON p.product_id = d.product_id
";

$params = [];
$where  = [];

// =====================
// キーワード（商品名）
// =====================
if ($searchWord !== '') {
    $where[] = 'p.name LIKE :searchWord';
    $params[':searchWord'] = '%' . $searchWord . '%';
}

// =========
// 開催地
// =========
if ($event_location !== '') {
    $where[] = 'p.location = :location';
    $params[':location'] = $event_location;
}

// ====================
// 開催日（開始・終了）
// ====================
if ($start_date !== '') {
    $where[] = 'd.start_time >= :start_date';
    $params[':start_date'] = $start_date . ' 00:00:00';
}

if ($end_date !== '') {
    $where[] = 'd.finish_time <= :end_date';
    $params[':end_date'] = $end_date . ' 23:59:59';
}

// =====================
// 開催期間カテゴリ
// =====================
switch ($event_duration) {
    case 'oneday':
        // 24時間未満
        $where[] = 'TIMESTAMPDIFF(HOUR, d.start_time, d.finish_time) < 24';
        break;

    case 'multiday':
        // 24時間以上 AND 24*7時間未満
        $where[] = 'TIMESTAMPDIFF(HOUR, d.start_time, d.finish_time) >= 24';
        $where[] = 'TIMESTAMPDIFF(HOUR, d.start_time, d.finish_time) < 24 * 7';
        break;

    case 'long':
        // 24*7時間以上
        $where[] = 'TIMESTAMPDIFF(HOUR, d.start_time, d.finish_time) >= 24 * 7';
        break;

    default:
        // 未選択 → 条件なし
        break;
}

// =====================
// タグ AND 条件
// =====================
$groupByHaving = '';

if (!empty($selected_tags)) {
    // tags/attached_tags を JOIN
    $sql .= "
        INNER JOIN attached_tags at
            ON p.product_id = at.product_id
    ";

    // IN (...) 用プレースホルダ
    $placeholders = [];
    foreach ($selected_tags as $i => $tag_id) {
        $ph = ':tag' . $i;
        $placeholders[] = $ph;
        $params[$ph] = (int)$tag_id;
    }

    // WHERE に at.tag_id IN (...)
    $where[] = 'at.tag_id IN (' . implode(',', $placeholders) . ')';

    // GROUP BY / HAVING で「選択したタグ数と一致」
    $groupByHaving = "
        GROUP BY p.product_id
        HAVING COUNT(DISTINCT at.tag_id) = :tag_count
    ";
    $params[':tag_count'] = count($selected_tags);
}

// =====================
// WHERE句の結合
// =====================
if (!empty($where)) {
    $sql .= ' WHERE ' . implode(' AND ', $where);
}

// GROUP BY / HAVING（タグ AND のときだけ中身あり）
$sql .= $groupByHaving;

// 並び順（開始時刻が近い順）
$sql .= ' ORDER BY d.start_time ASC';

// デバッグ確認用
 var_dump($sql, $params);

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<h2 class="title is-4" style="margin-top: 30px; margin-left: 25px;">検索結果</h2>

<?php foreach ($results as $product): ?>

    <div class="box" style="margin: 25px; display: flex; align-items: center;">
        <div style="flex-grow: 1;">
            <p>
                <span class="title is-4"><?= htmlspecialchars($product['name']) ?></span>
                <?php 
                $tag_sql = "
                    SELECT t.name
                    FROM tags t
                    INNER JOIN attached_tags at
                        ON t.tag_id = at.tag_id
                    WHERE at.product_id = :product_id
                ";
                $tag_stmt = $pdo->prepare($tag_sql);
                $tag_stmt->execute([':product_id' => $product['product_id']]);
                $tags = $tag_stmt->fetchAll(PDO::FETCH_ASSOC);
                ?>
                <?php foreach( $tags as $tag ) : ?>
                    <span><button class="button is-small is-primary is-outlined is-rounded" disabled><?= $tag['name']; ?></button></span>
                <?php endforeach; ?>
            </p>

            <p style="max-height: 300px;"><?= htmlspecialchars($product['detail']) ?></p>

            <p><strong>場所:</strong> <?= htmlspecialchars($product['location']) ?>
                <strong>所在地:</strong> <?= htmlspecialchars($product['address']) ?>
                <strong>参加人数:</strong>
                <?= htmlspecialchars($product['max_participants']) ?>/<?= htmlspecialchars($product['max_participants']) ?>人
            </p>
        </div>
        <div style="flex-shrink: 0; margin-left: 20px;">
            <img src="<?= htmlspecialchars($product['image_pass']) ?>"
                alt="<?= htmlspecialchars($product['name']) ?>"
                style="width: 150px; height: 100px; object-fit: cover; border-radius: 5px;">
        </div>
    </div>
<?php endforeach; ?>

<h2 class="title is-4" style="margin-top: 30px; margin-left: 25px;">検索結果は以上です</h2>


<?php require "parts/user_bottom.php"; ?>
<?php require "parts/footer.php"; ?>
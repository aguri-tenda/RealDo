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

$params = [];
$where  = [];

$sql = ''; // SQL本体
$sub_query_end = ''; // サブクエリの閉じとdatesとのJOIN句 (タグありの場合のみ使用)

if (!empty($selected_tags)) {
    // タグ検索がある場合のベースSQL (サブクエリ t1 を使用)
    $sql = "
        SELECT
            t1.product_id,
            t1.name,
            t1.location,
            t1.detail,
            t1.address,
            t1.image_pass,
            t1.max_participants,
            d.start_time,
            d.finish_time
        FROM dates d
        INNER JOIN (
            -- サブクエリ t1: タグ条件を満たす商品のみを抽出
            SELECT
                p.product_id,
                p.name,
                p.location,
                p.detail,
                p.address,
                p.image_pass,
                p.max_participants
            FROM products p
    ";
    
    // サブクエリのJOIN句、WHERE句、GROUP BY/HAVING句を組み立てるための変数
    $sub_query_joins = "
        INNER JOIN attached_tags att
            ON p.product_id = att.product_id
    ";
    $sub_query_where = [];
    $sub_query_group_by_having = '';
    
    // サブクエリを閉じてdatesテーブルとJOINする部分
    $sub_query_end = ' ) AS t1 ON d.product_id = t1.product_id ';
    
} else {
    // タグ検索がない場合のベースSQL (元のシンプル構造)
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
}

// =====================
// キーワード（商品名）
// =====================
if ($searchWord !== '') {
    $where[] = (!empty($selected_tags) ? 't1.name' : 'p.name') . ' LIKE :searchWord';
    $params[':searchWord'] = '%' . $searchWord . '%';
}

// =========
// 開催地
// =========
if ($event_location !== '') {
    $where[] = (!empty($selected_tags) ? 't1.location' : 'p.location') . ' = :location';
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
// タグ検索の組み立て
// =====================
if (!empty($selected_tags)) {
    // タグ検索がある場合、サブクエリ(t1)を完成させる
    
    // サブクエリのJOINを追加
    $sql .= $sub_query_joins;

    // IN (...) 用プレースホルダとWHERE句
    $placeholders = [];
    foreach ($selected_tags as $i => $tag_id) {
        $ph = ':tag' . $i;
        $placeholders[] = $ph;
        $params[$ph] = (int)$tag_id;
    }

    $sub_query_where[] = 'att.tag_id IN (' . implode(',', $placeholders) . ')';

    if (!empty($sub_query_where)) {
        $sql .= ' WHERE ' . implode(' AND ', $sub_query_where); 
    }

    // GROUP BY / HAVING で「選択したタグ数と一致」
    $sub_query_group_by_having = "
        GROUP BY p.product_id
        HAVING COUNT(DISTINCT att.tag_id) = :tag_count
    ";
    $params[':tag_count'] = count($selected_tags);
    $sql .= $sub_query_group_by_having; 

    // サブクエリを閉じる
    $sql .= $sub_query_end;
} 
// タグ検索がない場合は、ベースSQLが既にシンプル構造なので、何もしない

// =====================
// WHERE句の結合
// =====================
// メインクエリのWHERE句 (開催地、日付、期間、キーワード)を結合
if (!empty($where)) {
    $sql .= ' WHERE ' . implode(' AND ', $where);
}

// 並び順（開始時刻が近い順）
$sql .= ' ORDER BY d.start_time ASC';

// デバッグ確認用
 var_dump($sql, $params);

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

// =====================
// 各商品のタグを一括取得
// =====================
$product_ids = array_column($results, 'product_id');
$product_tags = []; 

if (!empty($product_ids)) {
    $id_placeholders = [];
    $id_params = [];
    foreach ($product_ids as $i => $id) {
        $ph = ':pid' . $i;
        $id_placeholders[] = $ph;
        $id_params[$ph] = (int)$id;
    }

    $tag_sql = "
        SELECT 
            at.product_id, 
            t.name
        FROM tags t
        INNER JOIN attached_tags at
            ON t.tag_id = at.tag_id
        WHERE at.product_id IN (" . implode(',', $id_placeholders) . ")
    ";

    $tag_stmt = $pdo->prepare($tag_sql);
    $tag_stmt->execute($id_params);
    $all_tags = $tag_stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($all_tags as $tag) {
        $product_id = $tag['product_id'];
        if (!isset($product_tags[$product_id])) {
            $product_tags[$product_id] = [];
        }
        $product_tags[$product_id][] = ['name' => $tag['name']];
    }
}

// =====================
// 商品IDでグルーピング
// =====================
$grouped_results = [];
foreach ($results as $product) {
    $product_id = $product['product_id'];
    if (!isset($grouped_results[$product_id])) {
        // 初めての商品の場合、基本情報を格納
        $grouped_results[$product_id] = [
            'product_info' => $product, // 商品名、場所などの情報
            'dates'        => [],      // 合致した日程リスト
        ];
    }
    // 日程情報を追加
    $grouped_results[$product_id]['dates'][] = [
        'start_time'  => $product['start_time'],
        'finish_time' => $product['finish_time'],
    ];
}
?>

<h2 class="title is-4" style="margin-top: 30px; margin-left: 25px;">検索結果</h2>

<?php foreach ($grouped_results as $product_id => $product_data): ?>

    <div class="box" style="margin: 25px; display: flex; align-items: center;">
        <div style="flex-grow: 1;">
            <p>
                <span class="title is-4"><?= htmlspecialchars($product_data['product_info']['name']) ?></span>
                <?php 
                $tags = $product_tags[$product_id] ?? []; 
                ?>
                <?php foreach( $tags as $tag ) : ?>
                    <span><button class="button is-small is-primary is-outlined is-rounded" disabled><?= htmlspecialchars($tag['name']); ?></button></span>
                <?php endforeach; ?>
            </p>

            <p style="max-height: 300px;"><?= htmlspecialchars($product_data['product_info']['detail']) ?></p>

            <p><strong>場所:</strong> <?= htmlspecialchars($product_data['product_info']['location']) ?>
                <strong>所在地:</strong> <?= htmlspecialchars($product_data['product_info']['address']) ?>
                <strong>参加人数:</strong>
                <?= htmlspecialchars($product_data['product_info']['max_participants']) ?>/<?= htmlspecialchars($product_data['product_info']['max_participants']) ?>人
                <strong>開催日程:</strong>
                <select>
                <?php foreach ($product_data['dates'] as $date): ?>
                    <option>
                        <?= htmlspecialchars($date['start_time']) ?> 〜 <?= htmlspecialchars($date['finish_time']) ?>
                    </option>
                <?php endforeach; ?>
                </select>
            </p>
        </div>
        <div style="flex-shrink: 0; margin-left: 20px;">
            <img src="<?= htmlspecialchars($product_data['product_info']['image_pass']) ?>"
                alt="<?= htmlspecialchars($product_data['product_info']['name']) ?>"
                style="width: 150px; height: 100px; object-fit: cover; border-radius: 5px;">
        </div>
    </div>
<?php endforeach; ?>

<h2 class="title is-4" style="margin-top: 30px; margin-left: 25px;">検索結果は以上です</h2>


<?php require "parts/user_bottom.php"; ?>
<?php require "parts/footer.php"; ?>
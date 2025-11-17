<?php require "parts/header.php"; ?>
<?php require "parts/navigation.php"; ?>
<?php require "parts/db-connect.php"; ?>

<?php
    $serchWord = $_POST['searchWord'] ?? '';
    $selected_tags = $_POST['tags'] ?? []; // 配列
    $start_date = $_POST['start_date'] ?? '';
    $end_date = $_POST['end_date'] ?? '';
    $event_location = $_POST['event_location'] ?? '';
    $event_duration = $_POST['event_duration'] ?? '';

    // --- SQLクエリの動的な組み立て ---
    $where_clauses = ["p.is_active = 1"]; // 常にアクティブな商品のみ

    // プレースホルダにバインドする値の配列
    $bind_values = [];

    // 1. キーワード検索
    if (!empty($serchWord)) {
        $where_clauses[] = "(
            p.name LIKE :search_word OR 
            p.detail LIKE :search_word OR 
            p.location LIKE :search_word
        )";
        // LIKE検索用にワイルドカードを追加
        $bind_values[':search_word'] = '%' . $serchWord . '%';
    }

    // 2. 場所の検索
    if (!empty($event_location)) {
        $where_clauses[] = "p.location = :location";
        $bind_values[':location'] = $event_location;
    }

    // 3. 日付の範囲検索 (開始日と終了日)
    if (!empty($start_date)) {
        $where_clauses[] = "p.start_date >= :start_date";
        $bind_values[':start_date'] = $start_date;
    }

    if (!empty($end_date)) {
        $where_clauses[] = "p.end_date <= :end_date";
        $bind_values[':end_date'] = $end_date;
    }

    // 4. 期間の検索 
    if (!empty($event_duration)) {
    
        
        $duration_condition = '';
        if ($event_duration === '日帰り') {
            $duration_condition = "DATEDIFF(p.end_date, p.start_date) = 0";
        } elseif ($event_duration === '2日以上') {
            $duration_condition = "DATEDIFF(p.end_date, p.start_date) >= 1 AND DATEDIFF(p.end_date, p.start_date) < 6";
        } elseif ($event_duration === '1週間以上') {
            $duration_condition = "DATEDIFF(p.end_date, p.start_date) >= 6";
        }
        
        if (!empty($duration_condition)) {
            $where_clauses[] = "(" . $duration_condition . ")";
        }
    }


    // 5. タグの検索
    // `$selected_tags`がある場合のみ、JOINとIN句で絞り込む
    $join_clause = "";
    if (!empty($selected_tags)) {
        // attached_tagsテーブルとのINNER JOINで、選択されたタグに紐づく商品のみに絞り込む
        $join_clause = "INNER JOIN attached_tags AS at ON p.product_id = at.product_id";
        
        // 選択されたタグIDの数だけプレースホルダを作成
        $tag_placeholders = implode(',', array_fill(0, count($selected_tags), '?'));
        
        // WHERE句にタグのIN条件を追加
        $where_clauses[] = "at.tag_id IN (" . $tag_placeholders . ")";
        
        // $bind_valuesにタグIDを数値として追加（PDOのexecuteに直接渡す形）
        foreach ($selected_tags as $tag_id) {
            $bind_values[] = (int)$tag_id;
        }
    }
    
    // 全てのWHERE句を ' AND ' で結合
    $where_sql = implode(" AND ", $where_clauses);
    
    // 最終的なSQLクエリ
    $sql_query = "
        SELECT 
            p.* FROM 
            products AS p
        " . $join_clause . "
        WHERE 
            " . $where_sql . "
    ";
    
    // タグ検索がある場合、同じ商品が複数回取得されるのを防ぐために GROUP BY を追加
    if (!empty($selected_tags)) {
        $sql_query .= " GROUP BY p.product_id";
    }

    // プリペアドステートメントの実行
    $sql = $pdo->prepare($sql_query);
    
    // bind_valuesの準備：名前付きプレースホルダ（:search_word, :location, :start_date, :end_date）と
    // クエスチョンマーク(?)プレースホルダ（タグID）が混在するため、実行方法を調整
    
    $execute_params = [];
    foreach ($bind_values as $key => $value) {
        if (is_string($key) && $key[0] === ':') {
            $sql->bindValue($key, $value);
        } else {
            // タグIDは execute() の配列に追加
            $execute_params[] = $value;
        }
    }
    
    $sql->execute($execute_params);
    $products = $sql->fetchAll(PDO::FETCH_ASSOC);

    // デバッグ用: 組み立てられたSQLクエリの確認
    // echo "<p><strong>SQL:</strong> " . htmlspecialchars($sql_query) . "</p>";

?>

<?php foreach ($products as $product): ?>

    <?php
        $product_duration = '';
        if ( !empty( $product['start_date'] ) && !empty( $product['end_date'] ) ) {
            $start = new DateTime( $product['start_date'] );
            $end = new DateTime( $product['end_date'] );
            $interval = $start->diff( $end );
            $days = $interval->days + 1;
        }
    ?>

    <h2 class="title is-4" style="margin-top: 30px; margin-left: 25px;">検索結果</h2>

    <div class="box" style="margin: 25px; display: flex; align-items: center;">
        <div style="flex-grow: 1;">
            <p>
                <span class="title is-4"><?= htmlspecialchars($product['name']) ?></span>

                <?php
                    // 商品に紐づくタグ名を取得し直す
                    $tag_names_stmt = $pdo->prepare( "SELECT tags.name FROM attached_tags JOIN tags ON attached_tags.tag_id = tags.tag_id WHERE product_id = ? ;" );
                    $tag_names_stmt->execute([ $product['product_id'] ]);
                    $product_tags = $tag_names_stmt->fetchAll(PDO::FETCH_ASSOC);
                ?>
                <?php foreach( $product_tags as $tag_info ) : ?>
                    <span><button class="button is-small is-primary is-outlined is-rounded" disabled><?= $tag_info['name']; ?></button></span>
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
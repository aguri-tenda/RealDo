<?php require "parts/header.php"; ?>
<?php require "parts/provider_navigation.php"; ?>
<?php require "parts/db-connect.php"; ?>

<?php
    $serchWord = $_POST['searchWord'] ?? '';
    $tags[] = $_POST['tags'] ?? [];
    $start_date = $_POST['start_date'] ?? '';
    $end_date = $_POST['end_date'] ?? '';
    $event_location = $_POST['event_location'] ?? '';
    $event_duration = $_POST['event_duration'] ?? '';

    $sql = $pdo->prepare("SELECT * FROM products;");
    $sql->execute();
    $products = $sql->fetchAll(PDO::FETCH_ASSOC);
?>

<?php
    $serchWord = $_POST['searchWord'] ?? '';
    $selected_tags = $_POST['tags'] ?? [];
    $start_date = $_POST['start_date'] ?? '';
    $end_date = $_POST['end_date'] ?? '';
    $event_location = $_POST['event_location'] ?? '';
    $event_duration = $_POST['event_duration'] ?? '';

    $sql = $pdo->prepare("SELECT * FROM products;");
    $sql->execute();
    $products = $sql->fetchAll(PDO::FETCH_ASSOC);
?>

<?php foreach ($products as $product): ?>

    <?php
        // 商品に紐づくタグ情報を取得し、タグIDの配列を作成する
        $tag_stmt = $pdo->prepare( "SELECT tag_id FROM attached_tags WHERE product_id = ? ;" );
        $tag_stmt->execute([ $product['product_id'] ]);
        $product_tag_ids = $tag_stmt->fetchAll(PDO::FETCH_COLUMN);

        $product_duration = '';
        if ( !empty( $product['start_date'] ) && !empty( $product['end_date'] ) ) {
            $start = new DateTime( $product['start_date'] );
            $end = new DateTime( $product['end_date'] );
            $interval = $start->diff( $end );
            $days = $interval->days + 1;
            if( $days == 1) {
                $product_duration = '日帰り';
            } else if( $days < 7) {
                $product_duration = '2日以上';
            } else if( $days >= 7) {
                $product_duration = '1週間以上';
            }
        }

        function check_tags_match($selected_tags, $product_tag_ids) {
            // 選択されたタグがない場合は、タグによる絞り込みは行わない（すべてOK）
            if (empty($selected_tags)) {
                return true;
            }
            // 選択されたタグのいずれか一つでも商品に紐づいていればOK
            foreach ($selected_tags as $selected_tag_id) {
                if (in_array($selected_tag_id, $product_tag_ids)) {
                    return true;
                }
            }
            return false;
        }

        // 絞り込み条件をチェック

        // キーワード検索
        $keyword_match = (
            empty($serchWord) ||
            (strpos($product['name'], $serchWord) !== false) ||
            (strpos($product['detail'], $serchWord) !== false) ||
            (strpos($product['location'], $serchWord) !== false)
        );

        // 場所、期間、日付の検索
        $location_match = (empty($event_location) || $product['location'] === $event_location);
        $duration_match = (empty($event_duration) || $product_duration === $event_duration);
        $start_date_match = (empty($start_date) || $product['start_date'] >= $start_date);
        $end_date_match = (empty($end_date) || $product['end_date'] <= $end_date);

        // タグの検索
        $tags_match = check_tags_match($selected_tags, $product_tag_ids);

        // どれか一つでも合わない条件があれば、その商品をスキップ
        if (
            !$keyword_match ||
            !$location_match ||
            !$duration_match ||
            !$start_date_match ||
            !$end_date_match ||
            !$tags_match
        ) {
            continue;
        }
    ?>

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




<?php require "parts/user_bottom.php"; ?>
<?php require "parts/footer.php"; ?>
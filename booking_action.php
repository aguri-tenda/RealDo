<?php session_start(); ?>
<?php require "parts/db-connect.php"; ?>
<?php
$user_id = $_SESSION['user']['userid'] ?? '';
//ポストデータ受け取り
$product_id = $_POST['product_id'] ?? '';
$people = $_POST['people'] ?? 1;
$datetime = $_POST['selected_date'] ?? '';
$names = $_POST['name'] ?? [];
$kanas = $_POST['kana'] ?? [];
$tels = $_POST['tel'] ?? [];
$remark = $_POST['remark'] ?? '';

$sql = $pdo->prepare(" SELECT * FROM products WHERE product_id = ? ; ");
$sql->execute([ $product_id ]);
$product = $sql->fetch(PDO::FETCH_ASSOC);

$date_participants_sql = $pdo->prepare(" SELECT purchased_num, max_participants FROM dates JOIN products ON dates.product_id = products.product_id WHERE dates.product_id = ? AND dates.start_time = ? ; ");
$date_participants_sql->execute([ $product_id, $datetime ]);
$date_participants = $date_participants_sql->fetch(PDO::FETCH_ASSOC);

if( ( $date_participants['purchased_num'] + $people ) > $date_participants['max_participants'] )
{
    echo "<p>申し訳ございません。選択された日時は既に定員オーバーとなっております。お手数ですが、再度予約をお願いいたします。</p>";
    echo '<a href="booking.php?product_id='. htmlspecialchars($product_id) .'">予約ページへ戻る</a>';
    exit();
}

$purchase_sql = $pdo->prepare(" INSERT INTO purchases( product_id, user_id, start_time, purchased_date, attendance, tel, remark) VALUE( ?, ?, ?, NOW(), ?, ?, ? ); ");
$participants_sql = $pdo->prepare(" INSERT INTO participants( purchase_id, participant_number, name, ruby, tel ) VALUE( ?, ?, ?, ?, ? ); ");
$dates_sql = $pdo->prepare(" UPDATE dates SET purchased_num = purchased_num + ? WHERE product_id = ? AND start_time = ? ; ");

$pdo->beginTransaction();
try
{
    //購入情報登録
    $purchase_sql->execute([ $product_id, $user_id, $datetime, $people, $tels[0], $remark ]);
    $purchase_id = $pdo->lastInsertId();

    //参加者情報登録
    for( $i = 0; $i < count( $names ); $i++ )
    {
        $participants_sql->execute([ $purchase_id, ( $i + 1 ), $names[$i], $kanas[$i], $tels[$i] ]);
    }

    //日時の購入数更新
    $dates_sql->execute([ $people, $product_id, $datetime ]);

    //タグカウント更新
    $tag_ids_sql = $pdo->prepare(" SELECT tag_id FROM attached_tags WHERE product_id = ? ; ");
    $tag_ids_sql->execute([ $product_id ]);
    $tag_ids = $tag_ids_sql->fetchAll(PDO::FETCH_COLUMN);
    $purchaseWeight = 1; // 購入の重み付け（必要に応じて調整可能）
    foreach ($tag_ids as $tag_id) {
        $tag_count_sql = $pdo->prepare("
            INSERT INTO tag_count (user_id, tag_id, attention_level)
            VALUES (:user_id, :tag_id, :attention_level)
            ON DUPLICATE KEY UPDATE attention_level = attention_level + :attention_level
        ");
        $tag_count_sql->execute([
            ':user_id' => $user_id,
            ':tag_id' => $tag_id,
            ':attention_level' => $purchaseWeight,
        ]);
    }

    $pdo->commit();
    header("Location: booking_show.php");
}
catch( Exception $e )
{
    $pdo->rollBack();
    //header("Location: error.php");
    echo '<div style="background-color: #ffeaea; border: 1px solid #c00; padding: 10px; margin-top: 15px;">';
    echo '<strong>エラー詳細（デバッグ情報）:</strong><br>';
    echo htmlspecialchars($e->getMessage());
    echo '</div>';
    exit();
}
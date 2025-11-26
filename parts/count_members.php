<?php
function countMembers( $pdo, $product_id )
{
    $max_participants_sql = $pdo->prepare("SELECT max_participants FROM products WHERE product_id = ?");
    $max_participants_sql->execute([ $product_id ]);
    $max = $max_participants_sql->fetch(PDO::FETCH_ASSOC);

    $dates_sql = $pdo->prepare("SELECT * FROM dates WHERE product_id = ?");
    $dates_sql->execute([$product_id]);
    $dates = $dates_sql->fetchAll(PDO::FETCH_ASSOC);

    $result = 0;
    foreach ( $dates as $date )
    {
        if ($date['purchased_num'] >= $result && $date['purchased_num'] < $max['max_participants']) {
            $result = $date['purchased_num'];
        }
    }
    return $result;
}
?>
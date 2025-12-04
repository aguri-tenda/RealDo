<?php session_start(); ?>
<?php require "parts/db-connect.php"; ?>
<?php
    if( isset( $_GET['purchase_id'] ) )
    {
        $getPurchases = $pdo->prepare(" SELECT * FROM purchases WHERE purchase_id = ? AND is_active = 1; ");
        $getPurchases->execute([ $_GET['purchase_id'] ]);
        $purchase = $getPurchases->fetch(PDO::FETCH_ASSOC);

        if( $purchase )
        {
            $purchaseUnactive = $pdo->prepare(" UPDATE purchases SET is_active = 0 WHERE purchase_id = ?; ");
            $purchaseUnactive->execute([ $_GET['purchase_id'] ]);
            $count_sql = $pdo->prepare(" SELECT SUM( attendance ) AS total FROM purchases WHERE product_id = ? AND start_time = ? AND is_active = 1; ");
            $count_sql->execute([ $purchase['product_id'], $purchase['start_time'] ]);

            foreach( $count_sql as $attendance )
            {
                $attendanceSet = $pdo->prepare(" UPDATE dates SET purchased_num = ? WHERE product_id = ? AND start_time = ? ; ");
                $attendanceSet->execute([ $attendance['total'], $purchase['product_id'], $purchase['start_time'] ]);
            }
        }


        header( "Location: booking_show.php?user_id=". $_GET['user_id'] );
        exit();
    }
    else
    {
        header( "Location: booking_show.php?user_id=". $_GET['user_id'] );
        exit();
    }
?>
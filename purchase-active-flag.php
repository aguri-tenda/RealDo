<?php session_start(); ?>
<?php require "parts/db-connect.php"; ?>
<?php
    if( isset( $_GET['purchase_id'] ) )
    {
        $sql = $pdo->prepare( "UPDATE purchases SET is_active = !is_active WHERE purchase_id = ? ;" );
        $sql->execute([ $_GET['purchase_id'] ]);

        $getPurchases = $pdo->prepare(" SELECT * FROM purchases WHERE purchase_id = ? AND is_active = 1; ");
        $getPurchases->execute([ $_GET['purchase_id'] ]);
        $getPurchases->fetch();

        if( $getPurchases )
        {
            foreach( $getPurchases as $purchases )
            {
                $purchaseUnactive = $pdo->prepare(" UPDATE purchases SET is_active = 0 WHERE purchase_id = ?; ");
                $purchaseUnactive->execute([ $_GET['purchase_id'] ]);
                $count_sql = $pdo->prepare(" SELECT SUM( attendance ) AS total FROM purchases WHERE product_id = ? AND start_time = ? AND is_active = 1; ");
                $count_sql->execute([ $purchases['product_id'], $purchases['start_time'] ]);

                foreach( $count_sql as $attendance )
                {
                    $attendanceSet = $pdo->prepare(" UPDATE dates SET purchased_num = ? - ? WHERE product_id = ? AND start_time = ? ; ");
                    $attendanceSet->execute([ $attendance['total'], $purchases['attendance'], $purchases['product_id']. $purchases['start_time'] ]);
                }
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
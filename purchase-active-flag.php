<?php session_start(); ?>
<?php require "parts/db-connect.php"; ?>
<?php
    if( isset( $_GET['purchase_id'] ) )
    {
        $sql = $pdo->prepare( "UPDATE purchases SET is_active = !is_active WHERE purchase_id = ? ;" );
        $sql->execute([ $_GET['purchase_id'] ]);

        header( "Location: booking_show.php?user_id=". $_GET['user_id'] );
        exit();
    }
    else
    {
        header( "Location: booking_show.php?user_id=". $_GET['user_id'] );
        exit();
    }
?>
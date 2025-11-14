<?php session_start(); ?>
<?php require "parts/db-connect.php"; ?>

<?php
    if( isset( $_GET['product_id'] ) )
    {
        $sql = $pdo->prepare( "UPDATE products SET is_active = !is_active WHERE product_id = ? && provider_id = ?;" );
        $sql->execute([ $_GET['product_id'], $_SESSION['provider']['providerid'] ]);

        header( "Location: product-management.php" );
        exit();
    }
    else
    {
        header( "Location: product-management.php" );
        exit();
    }
?>
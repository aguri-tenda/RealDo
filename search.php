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

<?php foreach ($products as $product): ?>
                
    <?php
        $tag = $pdo->prepare( "SELECT * FROM attached_tags JOIN tags ON attached_tags.tag_id = tags.tag_id WHERE product_id = ? ;" );
        $tag->execute([ $product['product_id'] ]);
    ?>

    <div class="box" style="margin: 25px; display: flex; align-items: center;">
        <div style="flex-grow: 1;">
            <p>
                <span class="title is-4"><?= htmlspecialchars($product['name']) ?></span>

                <?php foreach( $tag as $tags ) : ?>
                    <span><button class="button is-small is-primary is-outlined is-rounded" disabled><?= $tags['name']; ?></button></span>
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
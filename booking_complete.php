<?php
require "parts/header.php";
require "parts/navigation.php";
require "parts/db-connect.php";
?>

<link rel="stylesheet" href="parts/style.css">

<div class="container">
    <h1>予約完了</h1>

    <form method="post" action="booking_confirm.php">
        <div>
            <label>参加人数</label>
            <input type="number" name="number" value="1" min="1">
        </div>

        <div>
            <label>参加日時</label>
            <input type="datetime-local" name="datetime" value="2022-01-01T00:00">
        </div>

        <div>
            <label>参加者氏名</label>
            <input type="text" name="name" value="山田太郎">
        </div>

        <button type="submit">確定</button>
    </form>
</div>

<?php
require "parts/user_bottom.php";
require "parts/footer.php";
?>

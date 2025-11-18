<?php
require "parts/header.php";
require "parts/navigation.php";
require "parts/db-connect.php";
?>

<div class="container">
    <h1 class="title is-3 has-text-centered">予約完了</h1>

    <form method="post" action="booking_confirm.php">

        <!-- 参加人数 -->
        <div class="field">
            <label class="label">参加人数</label>
            <div class="control">
                <input class="input" type="number" name="number" value="1" min="1">
            </div>
        </div>

        <!-- 参加日時 -->
        <div class="field">
            <label class="label">参加日時</label>
            <div class="control">
                <input class="input" type="datetime-local" name="datetime" value="2022-01-01T00:00">
            </div>
        </div>

        <!-- 参加者名 -->
        <div class="field">
            <label class="label">参加者氏名</label>
            <div class="control">
                <input class="input" type="text" name="name" value="山田太郎">
            </div>
        </div>

        <!-- ボタン -->
        <div class="field has-text-centered">
            <button class="button is-info is-medium" type="submit">確定</button>
        </div>

    </form>
</div>

<?php
require "parts/user_bottom.php";
require "parts/footer.php";
?>

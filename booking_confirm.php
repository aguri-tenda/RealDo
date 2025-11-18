<?php
require "parts/header.php";
require "parts/navigation.php";
require "parts/db-connect.php";

$date = new DateTime('now', new DateTimeZone('Asia/Tokyo'));
$date->add(new DateInterval('P1D')); // 明日
?>

<link rel="stylesheet" href="parts/style.css">

<div class="container">
    <h1>予約フォーム</h1>

    <form method="post" action="booking_confirm.php">

        <div>
            <label>参加人数</label>
            <input type="number" name="people" value="1" min="1">
        </div>

        <div>
            <label>参加日時</label>
            <div class="datetime-box">
                <input type="date" name="date" value="<?php echo $date->format('Y-m-d'); ?>">
                <select name="time">
                    <option value="">時間を選択</option>
                    <?php
                    for ($h = 0; $h < 24; $h++) {
                        foreach ([0, 30] as $m) {
                            $value = sprintf('%02d:%02d', $h, $m);
                            $label = sprintf('%02d時%02d分', $h, $m);
                            echo "<option value='{$value}'>{$label}</option>";
                        }
                    }
                    ?>
                </select>
            </div>
        </div>

        <div>
            <label>参加者情報</label>
            <input type="text" name="last_name" placeholder="姓（例：田中）">
            <input type="text" name="kana_last" placeholder="フリガナ（例：タナカ）">
            <input type="text" name="first_name" placeholder="名（例：太郎）">
            <input type="text" name="kana_first" placeholder="フリガナ（例：タロウ）">
            <input type="text" name="tel" placeholder="電話番号（例：000-0000-0000）">
        </div>

        <button type="submit">確定</button>
    </form>
</div>

<?php
require "parts/user_bottom.php";
require "parts/footer.php";
?>

<?php
require "parts/header.php";
require "parts/navigation.php";

// POSTデータ受け取り
$product_id = $_POST['product_id'] ?? '';
$people = $_POST['people'] ?? 1;
$datetime = $_POST['selected_date'] ?? '';
$names = $_POST['name'] ?? [];
$kanas = $_POST['kana'] ?? [];
$tels = $_POST['tel'] ?? [];
$remark = $_POST['remark'] ?? '';
?>

<br>

<div class="level-item">
    <form class="box" style="width: 700px; text-align: center;" action="booking_action.php" method="post">
        <span class="subtitle is-4" style="color:#278EDD;">予約内容確認</span>
        <br><br>

        <!-- 参加人数 -->
        <div class="field is-horizontal">
            <div class="field-label is-normal">
                <label style="color:#278EDD;">参加人数</label>
            </div>
            <div class="field-body">
                <div class="field">
                    <input disabled class="input" type="text" value="<?= htmlspecialchars($people) . ' 人' ?>"
                        style="background-color:#E3FFFF;width:80%;border:1px solid #858484ff;">
                </div>
            </div>
        </div>

        <!-- 参加日時 -->
        <div class="field is-horizontal">
            <div class="field-label is-normal">
                <label style="color:#278EDD;">参加日時</label>
            </div>
            <div class="field-body">
                <div class="field">
                    <input disabled class="input" type="text" value="<?= htmlspecialchars($datetime) ?>"
                        style="background-color:#E3FFFF;width:80%;border:1px solid #858484ff;">
                </div>
            </div>
        </div>

        <br>
        <span class="subtitle is-5" style="color:#278EDD;">参加者情報</span>
        <br><br>

        <!-- 参加者情報（人数分ループ） -->
        <?php for ($i = 0; $i < count($names); $i++): ?>
            <!-- 氏名 -->
            <div class="field is-horizontal">
                <div class="field-label is-normal">
                    <label style="color:#278EDD;">氏名 <?= ($i + 1) ?></label>
                </div>
                <div class="field-body">
                    <div class="field">
                        <input disabled class="input" type="text" value="<?= htmlspecialchars($names[$i]) ?>"
                            style="background-color:#E3FFFF;width:80%;border:1px solid #858484ff;">
                    </div>
                </div>
            </div>

            <!-- フリガナ -->
            <div class="field is-horizontal">
                <div class="field-label is-normal">
                    <label style="color:#278EDD;">フリガナ</label>
                </div>
                <div class="field-body">
                    <div class="field">
                        <input disabled class="input" type="text" value="<?= htmlspecialchars($kanas[$i]) ?>"
                            style="background-color:#E3FFFF;width:80%;border:1px solid #858484ff;">
                    </div>
                </div>
            </div>

            <!-- 電話番号 -->
            <div class="field is-horizontal">
                <div class="field-label is-normal">
                    <label style="color:#278EDD;">電話番号</label>
                </div>
                <div class="field-body">
                    <div class="field">
                        <input disabled class="input" type="text" value="<?= htmlspecialchars($tels[$i]) ?>"
                            style="background-color:#E3FFFF;width:80%;border:1px solid #858484ff;">
                    </div>
                </div>
            </div>

            <br>
        <?php endfor; ?>

        <!-- 備考 -->
        <div class="field is-horizontal">
            <div class="field-label is-normal">
                <label style="color:#278EDD;">備考</label>
            </div>
            <div class="field-body">
                <div class="field">
                    <textarea disabled class="textarea" style="background-color:#E3FFFF; border:1px solid #858484ff; width:80%; height:100px; resize:none;"><?= htmlspecialchars($remark) ?></textarea>
                </div>
            </div>
        </div>

        <!-- hidden で次画面にデータを送る -->
        <input type="hidden" name="product_id" value="<?= htmlspecialchars($product_id) ?>">
        <input type="hidden" name="booking_people" value="<?= htmlspecialchars($people) ?>">
        <input type="hidden" name="booking_datetime" value="<?= htmlspecialchars($datetime) ?>">

        <?php foreach ($names as $n): ?>
            <input type="hidden" name="booking_name[]" value="<?= htmlspecialchars($n) ?>">
        <?php endforeach; ?>

        <?php foreach ($kanas as $k): ?>
            <input type="hidden" name="booking_kana[]" value="<?= htmlspecialchars($k) ?>">
        <?php endforeach; ?>

        <?php foreach ($tels as $t): ?>
            <input type="hidden" name="booking_tel[]" value="<?= htmlspecialchars($t) ?>">
        <?php endforeach; ?>

        <!-- ボタン -->
        <div class="field has-text-centered" style="margin-top: 2rem; margin-bottom: 2rem;">
            <a href="booking.php?product_id=<?= htmlspecialchars($product_id) ?>" class="button is-light is-medium" style="margin-right: 20px;">
                戻る
            </a>

            <button class="button is-link is-medium" style="background-color: #41C0FF; width: 40%;">
                この内容で予約する
            </button>
        </div>

    </form>
</div>

<?php require "parts/user_bottom.php"; ?>
<?php require "parts/footer.php"; ?>
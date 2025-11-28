<?php
require "parts/header.php";
require "parts/navigation.php";

?>
<?php
$product_id = $_GET['product_id'] ?? '';
$sql = $pdo->prepare("SELECT * FROM products WHERE product_id = ?");
$sql->execute([$product_id]);
$product = $sql->fetch(PDO::FETCH_ASSOC);
if (!$product) {
    echo "<p>Product not found.</p>";
    exit;
}
if (!isset($_SESSION['user'])) {
    echo "<p>Please log in to make a booking.</p>";
    exit;
}
$dates_sql = $pdo->prepare("SELECT * FROM dates WHERE product_id = ? ORDER BY start_time ASC");
$dates_sql->execute([$product_id]);
$dates = $dates_sql->fetchAll(PDO::FETCH_ASSOC);
?>
<br>

<div class="container is-flex is-justify-content-center" id="app-booking">
    <div class="level">
        <a href="<?= $_SERVER['HTTP_REFERER']; ?>"><input type="button" class="button is-link level-left" value="戻る"></a>
    </div>
    <form class="box" style="max-width: 1200px; width: 100%; padding: 40px; border-radius: 10px;" method="post"
        action="booking_complete.php">

        <h1 class="title is-3 has-text-centered" style="color: #278EDD; margin-bottom: 40px;">
            予約フォーム
        </h1>

        <!-- 参加人数 + 参加日時 -->
        <div class="field is-horizontal mb-5">
            <div class="field-label is-normal" style="width: 150px;">
                <label class="label" style="color: #278EDD;">参加人数</label>
            </div>

            <div class="field-body">
                <div class="field">
                    <div class="control">
                        <input class="input" style="width: 120px;" type="number" name="people" v-model.number="participants" min="1">
                    </div>
                </div>

                <div class="field-label is-normal" style="margin-left: 30px; width: 120px;">
                    <label class="label" style="color: #278EDD;">参加日時</label>
                </div>

                <div class="field">
                    <div class="control">
                        <select class="select" style="width: 260px;" name="selected_date" required>
                            <?php foreach ($dates as $date): ?>
                                <option value="<?= $date['start_time'] ?>" <?= (strtotime($date['start_time']) < time()) ? 'disabled' : '' ?>>
                                    <?= htmlspecialchars($date['start_time']) ?>〜<?= htmlspecialchars($date['finish_time']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <hr style="margin: 25px 0;">

        <label class="label" style="color: #278EDD; margin-bottom: 15px; font-size: 1.2rem;">
            参加者情報
        </label>

        <div id="participant-forms">

            <!-- 参加者フォーム -->
            <participant-box
                v-for="n in participants"
                :key="n"
                :index="n"
            ></participant-box>

        </div>

        <hr style="margin: 25px 0;">

        <label class="label" style="color: #278EDD; margin-bottom: 15px; font-size: 1.2rem;">
            備考
        </label>
        <div class="field">
            <div class="control">
                <textarea class="textarea" name="remark" placeholder="何かあればご記入ください。" style="background-color:#E3FFFF; border:1px solid #858484ff; resize:none; height: 100px;"></textarea>
            </div>
        </div>

        <div class="field has-text-centered">
            <button class="button is-info is-medium"
                style="background-color: #41C0FF; width: 50%; height: 50px; border-radius: 8px; margin-bottom: 2rem;">
                確定
            </button>
        </div>
        <input type="hidden" name="product_id" value="<?= htmlspecialchars($product_id) ?>">
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/vue@2.7.11/dist/vue.js"></script>
<script src="script/booking-script.js"></script>

<?php
require "parts/user_bottom.php";
require "parts/footer.php";
?>
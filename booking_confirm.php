<?php
require "parts/header.php";
require "parts/navigation.php";
require "parts/db-connect.php";
?>
<?php
$start_date = $_POST['start_date'] ?? '';
$end_date = $_POST['end_date'] ?? '';
?>
<br>

<div class="container is-flex is-justify-content-center" id="app-booking-confirm">
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
                        <input class="input" style="width: 120px;" type="number" name="people" v-model="participants" min="1">
                    </div>
                </div>

                <div class="field-label is-normal" style="margin-left: 30px; width: 120px;">
                    <label class="label" style="color: #278EDD;">参加日時</label>
                </div>

                <div class="field">
                    <div class="control">
                        <select class="select" style="width: 260px;" name="selected_date">
                            <?php foreach ($product_data['dates'] as $date): ?>
                                <option value="<?= $date['start_time'] ?>">
                                    <?= htmlspecialchars($date['start_time']) ?>〜<?= htmlspecialchars($date['finish_time']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <hr style="margin: 25px 0;">

        <!-- 参加者情報 label -->
        <label class="label" style="color: #278EDD; margin-bottom: 15px; font-size: 1.2rem;">
            参加者情報
        </label>

        <!-- 🔽 参加者フォームをまとめるコンテナ -->
        <div id="participants-container">

            <!-- 参加者フォーム -->
            <participant-box
                v-for="n in participants"
                :key="n"
                :index="n"
            ></participant-box>

        </div>
        
        <hr style="margin: 25px 0;">

        <!-- ボタン -->
        <div class="field has-text-centered">
            <button class="button is-info is-medium"
                style="background-color: #41C0FF; width: 50%; height: 50px; border-radius: 8px;">
                確定
            </button>
        </div>

    </form>
</div>
<?php
require "parts/user_bottom.php";
require "parts/footer.php";
?>
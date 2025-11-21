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

<div class="container">
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
                        <input class="input" style="width: 120px;" type="number" name="people" value="1" min="1">
                    </div>
                </div>

                <div class="field-label is-normal" style="margin-left: 30px; width: 120px;">
                    <label class="label" style="color: #278EDD;">参加日時</label>
                </div>

                <div class="field">
                    <div class="control">
                        <select class="select" style="width: 260px;">
                            <?php foreach ($product_data['dates'] as $date): ?>
                                <option>
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

            <!-- 1人目の入力欄（テンプレ） -->
            <div class="participant-box">

                <!-- 氏名・フリガナ -->
                <div class="field is-horizontal mb-4">
                    <div class="field-label is-normal" style="width: 150px;">
                        <label class="label" style="color: #278EDD;">参加者氏名</label>
                    </div>

                    <div class="field-body">
                        <div class="field">
                            <input class="input" type="text" style="width: 250px;" name="name[]" placeholder="田中 太郎">
                        </div>

                        <div class="field-label is-normal" style="margin-left: 30px; width: 120px;">
                            <label class="label" style="color: #278EDD;">フリガナ</label>
                        </div>

                        <div class="field">
                            <input class="input" type="text" style="width: 300px;" name="kana[]" placeholder="タナカ タロウ">
                        </div>
                    </div>
                </div>

                <!-- 電話番号 -->
                <div class="field is-horizontal mb-4">
                    <div class="field-label is-normal" style="width: 150px;">
                        <label class="label" style="color: #278EDD;">電話番号（TEL）</label>
                    </div>

                    <div class="field-body">
                        <div class="field">
                            <input class="input" type="text" style="width: 250px;" name="tel[]"
                                placeholder="00000000000">
                        </div>
                    </div>
                </div>
                <hr style="margin: 25px 0;">
            </div>
        </div>

        <!-- 🔽 参加者追加ボタン -->
        <div class="field is-horizontal mb-4">
            <div class="field-label is-normal" style="width: 150px;">
            </div>

            <div class="field-body">
                <button type="button" id="add-participant-btn" class="button is-link is-light"
                    style="border-radius: 6px; padding: 0 20px;">
                    ＋ 参加者を追加する
                </button>
            </div>
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
<script>
    document.getElementById("add-participant-btn").addEventListener("click", function () {
        const container = document.getElementById("participants-container");

        // 1人目の participant-box をそのままコピー
        const firstBox = container.querySelector(".participant-box");
        const newBox = firstBox.cloneNode(true);

        // 入力内容を空にする
        newBox.querySelectorAll("input").forEach(input => {
            input.value = "";
        });

        // 参加者フォームを追加
        container.appendChild(newBox);
    });
</script>
<?php
require "parts/user_bottom.php";
require "parts/footer.php";
?>
<?php require "parts/header.php"; ?>
<?php require "parts/navigation.php"; ?>
<?php require "parts/db-connect.php"; ?>

<div class="container">
    <h1 class="title is-3 has-text-centered">参加者情報</h1>

    <form method="post" action="booking_complete.php">
        <input type="hidden" name="product_id" value="<?= htmlspecialchars($_POST['product_id']) ?>">
        <input type="hidden" name="people" value="<?= htmlspecialchars($_POST['people']) ?>">
        <input type="hidden" name="date_id" value="<?= htmlspecialchars($_POST['date_id']) ?>">
        <input type="hidden" name="tel" value="<?= htmlspecialchars($_POST['tel']) ?>">

        <?php for ($i = 1; $i <= (int)$_POST['people']; $i++): ?>
            <div class="box">
                <h2 class="title is-4">参加者 <?= $i ?></h2>

                <div class="field">
                    <label class="label">性</label>
                    <div class="control">
                        <input class="input" type="text" name="participant_last_name[]" placeholder="例：山田" required>
                    </div>
                </div>

                <div class="field">
                    <label class="label">名</label>
                    <div class="control">
                        <input class="input" type="text" name="participant_first_name[]" placeholder="例：太郎" required>
                    </div>
                </div>

                <div class="field">
                    <label class="label">性(フリガナ)</label>
                    <div class="control">
                        <input class="input" type="text" name="participant_kana_last[]" placeholder="例：ヤマダ" required>
                    </div>
                </div>

                <div class="field">
                    <label class="label">名(フリガナ)</label>
                    <div class="control">
                        <input class="input" type="text" name="participant_kana_first[]" placeholder="例：タロウ" required>
                    </div>
                </div>

                <div class="field">
                    <label class="label">緊急連絡先</label>
                    <div class="control">
                        <input class="input" type="text" name="participant_tel[]" placeholder="例：090-1234-5678" required>
                    </div>
                </div>

            </div>
        <?php endfor; ?>
        <div class="field has-text-centered">
            <div class="control">
                <button class="button is-primary" type="submit">予約を確定する</button>
            </div>
        </div>
    </form>
</div>
<?php require "parts/user_bottom.php"; ?>
<?php require "parts/footer.php"; ?>
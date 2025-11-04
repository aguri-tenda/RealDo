<?php require "parts/header.php"; ?>
<?php require "parts/navigation.php"; ?>

<div class="level-item">
    <form class="box" style="width: 800px; text-align: center;">
        <span class="subtitle is-4" style="color:#278EDD;">レビュー投稿</span>
        <div class="field is-horizontal">
            <div class="field-label is-normal">
                <label style="color:#278EDD;">評価</label>
            </div>
            <div class="field-body">
                <div class="field">
                    <div class="control">
                        <input class="input" type="text" name="rating" style="background-color: #D9D9D9;">
                    </div>
                </div>
            </div>
        </div>

        <div class="field is-horizontal">
            <div class="field-body">
                <div class="field">
                    <div class="control">
                        <input class="input" type="text" name="review" style="background-color: #D9D9D9;">
                    </div>
                </div>
            </div>
        </div>

        <!-- ボタン -->
        <div class="field has-text-centered" style="margin-top: 2rem;">
            <input class="button is-info" type="submit" value="確定" style="background-color: #41C0FF; width: 300px;">
        </div>

    </form>
</div>

<?php require "parts/user_bottom.php"; ?>
<?php require "parts/footer.php"; ?>

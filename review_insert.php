<?php require "parts/header.php"; ?>
<?php require "parts/navigation.php"; ?>

<div class="level-item">
    <form class="box" style="width: 520px; text-align: center;" action="review_complete.php" method="post">
            <span class="subtitle is-4" style="color:#278EDD;">レビュー投稿</span>
        <div class="field is-horizontal" style="margin-top: 2rem;">
            <div class="field-label is-medium">
                <label class="label" style="color:#278EDD;">評価</label>
            </div>
            <div class="field-body">
                <div class="field">
                    <div id="vue-rating-app">
                        <rating-selector rating="0"></rating-selector>
                    </div>
                    <input type="hidden" name="rating" id="rating-value" value="0">
                </div>
            </div>
        </div>

        <div class="field is-horizontal" style="margin-top: 1.5rem;">
            <div class="field-label is-medium">
                <label class="label" style="color:#278EDD;">レビュー内容</label>
            </div>
            <div class="field-body">
                <div class="field">
                    <div class="control">
                        <textarea class="textarea" rows="4"  type="text" name="review" style="background-color: #fff; resize: none;"></textarea>
                    </div>
                </div>
            </div>
        </div>

        <div class="field has-text-centered" style="margin-top: 3rem;">
            <input class="button is-info" type="submit" value="確定" style="background-color: #41C0FF; width: 300px;">
        </div>

    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/vue@2.7.11/dist/vue.js"></script>
<script src="script/review_insert-script.js"></script>

<?php require "parts/user_bottom.php"; ?>
<?php require "parts/footer.php"; ?>
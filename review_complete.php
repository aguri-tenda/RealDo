<?php require "parts/header.php"; ?>
<?php require "parts/navigation.php"; ?>
<?php 
$product_id = $_SESSION['review']['product_id'] ?? '';
$_SESSION['review']['rating-value'] = $_POST['rating'] ?? 1;
$_SESSION['review']['reviewtext'] = $_POST['reviewtext'] ?? '';
$rating_value = $_POST['rating'] ?? 1;
$reviewtext = $_POST['reviewtext'] ?? '';
?>
<br>
<div class="level-item">
    <form class="box" style="width: 520px; text-align: center;" action="review_action.php" method="post">
        <span class="subtitle is-4" style="color:#278EDD;">登録内容確認</span>

        <div class="field is-horizontal" style="margin-top: 2rem;">
            <div class="field-label is-medium">
                <label class="label" style="color:#278EDD;">評価</label>
            </div>
            <div class="field-body">
                <div class="field">
                    <div id="vue-rating-app">
                        <rating-selector rating="<?php echo htmlspecialchars($rating_value); ?>"
                            disabled="true"></rating-selector>
                    </div>
                    <input type="hidden" name="rating" id="rating-value"
                        value="<?php echo htmlspecialchars($rating_value); ?>">
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
                        <textarea disabled class="textarea" rows="4" type="text" name="reviewtext"
                            style="background-color: #fff; resize: none;"><?php echo htmlspecialchars($reviewtext); ?></textarea>
                    </div>
                </div>
            </div>
        </div>

        <div class="field has-text-centered" style="margin-top: 2rem;">
            <a href="review_insert.php?product_id=<?php echo htmlspecialchars($product_id); ?>&reviewtext=<?php echo urlencode($reviewtext); ?>&rating=<?php echo urlencode($rating_value); ?>" class="button is-light is-medium" style="margin-right: 20px;">戻る</a>
            <input class="button is-link is-medium" type="submit" value="登録する"
                style="background-color: #41C0FF; width: 40%;">
        </div>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/vue@2.7.11/dist/vue.js"></script>
<script src="script/review_insert-script.js"></script>

<?php require "parts/user_bottom.php"; ?>
<?php require "parts/footer.php"; ?>
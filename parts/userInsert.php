<?php require "parts/header.php"; ?>
<?php require "parts/navigation.php"; ?>
<div class="level">
    <form class="box">
        <div class="field">
            <div class="control">
                <label class="label">ユーザー名</label>
                <input class="input" type="text" name="username">
            </div>
        </div>

        <div class="field">
            <div class="control">
                <label class="label">ユーザーID</label>
                <input class="input" type="text" name="userid">
            </div>
        </div>
        <div class="field">
            <div class="control">
                <label class="label">メールアドレス</label>
                <input class="input" type="email" name="useremail">
            </div>
        </div>
        <div class="field">
            <div class="control">
                <label class="label">パスワード</label>
                <input class="input" type="text" name="password">
            </div>
        </div>
        <button class="button #41C0FF">確定</button>
    </form>
</div>
<?php require "parts/user_bottom.php"; ?>
<?php require "parts/footer.php"; ?>
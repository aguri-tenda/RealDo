<?php require "parts/header.php"; ?>
<?php require "parts/navigation.php"; ?>

<div class="level-item">
    <form class="box" style="width: 800px; text-align: center;">
        <span class="subtitle is-4" style="color:#278EDD;">商品情報更新完了</span>
        <br>
        <div class="field is-horizontal">
            <div class="field-label is-normal">
                <label style="color:#278EDD;">参加可能人数</label>
            </div>
            <div class="field-body">
                <div class="field">
                    <div class="control">
                        <input class="input" type="text" name="username" style="background-color: #D9D9D9;  width:50px;">人まで
                    </div>
                </div>
            </div>
            <div class="field-label is-normal">
                <label style="color:#278EDD;">開催日時</label>
            </div>
            <div class="field-body">
                <div class="field">
                    <div class="control">
                        <div class="select">
                            <select name="day" style="background-color: #fff; width:160px;">
                            
                            </select>
                        </div>
                    </div>
                    <div class="control">
                         <div class="select">
                            <select name="day" style="background-color: #fff; width:110px;">
                            
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <hr>
        <label style="text-align:left; color:#278EDD;">イベント情報</lebel>
        <div class="field is-horizontal">
            <div class="field-label is-normal">
                <label style="color:#278EDD;">イベント名</label>
            </div>
            <div class="field-body">
                <div class="field">
                    <div class="control">
                        <input class="input" type="text" name="username" style="background-color: #D9D9D9;">
                    </div>
                </div>
            </div>
        </div>

        <div class="field is-horizontal">
            <div class="field-label is-normal">
                <label style="color:#278EDD;">開催地</label>
            </div>
            <div class="field-body">
                <div class="field">
                    <div class="control">
                        <input class="input" type="text" name="userid" style="background-color: #D9D9D9;">
                    </div>
                </div>
            </div>
        </div>

        <div class="field is-horizontal">
            <div class="field-label is-normal">
                <label style="color:#278EDD;">開催地所在地</label>
            </div>
            <div class="field-body">
                <div class="field">
                    <div class="control">
                        <input class="input" type="email" name="useremail" style="background-color: #D9D9D9;">
                    </div>
                </div>
            </div>
        </div>

        <div class="field is-horizontal">
            <div class="field-label is-normal">
                <label style="color:#278EDD;">主催連絡先（TEL）</label>
            </div>
            <div class="field-body">
                <div class="field">
                    <div class="control">
                        <input class="input" type="password" name="password" style="background-color: #D9D9D9;">
                    </div>
                </div>
            </div>
        </div>

        <!-- ボタン -->
        <div class="field has-text-centered" style="margin-top: 2rem;">
            <input class="button is-info" type="submit" value="ホーム画面へ" style="background-color: #41C0FF; width: 300px;">
        </div>

    </form>
</div>

<?php require "parts/provider_bottom.php"; ?>
<?php require "parts/footer.php"; ?>

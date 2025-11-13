<?php require "parts/db-connect.php"; ?>
<?php
$sql = $pdo->prepare("SELECT * FROM tags");
$sql->execute();
$tags = $sql->fetchAll(PDO::FETCH_ASSOC);
?>
<div id="app-navigation">
    <nav class="navbar is-light" role="navigation" aria-label="main navigation">
        <div class="navbar-brand">
            <a class="navbar-item" href="./index.php">
                <img src="img/logo.png" alt="RealDo" style="max-height: 60px;">
            </a>

            <!-- ✅ ハンバーガーメニュー -->
            <a role="button" class="navbar-burger" :class="{ 'is-active': isMenuActive }" aria-label="menu"
                aria-expanded="false" @click="toggleMenu">
                <span aria-hidden="true"></span>
                <span aria-hidden="true"></span>
                <span aria-hidden="true"></span>
            </a>
        </div>

        <!-- ✅ PHP入りメニュー部 -->
        <div id="navbarMenu" class="navbar-menu" :class="{ 'is-active': isMenuActive }">
            <div class="navbar-end">

                <!-- 検索 -->
                <div class="navbar-item">
                    <a id="search" class="is-flex is-align-items-center" @click="toggleSearch">
                        <span class="icon has-text-info"><i class="fas fa-search"></i></span>
                        <span>検索</span>
                    </a>
                </div>

                <!-- ユーザー登録 or 更新 -->
                <div class="navbar-item">
                    <?php if (isset($_SESSION['user'])): ?>
                        <a href="./userUpdate.php" class="is-flex is-align-items-center">
                            <span class="icon has-text-info"><i class="far fa-edit"></i></span>
                            <span>ユーザー情報更新</span>
                        </a>
                    <?php else: ?>
                        <a href="./userInsert.php" class="is-flex is-align-items-center">
                            <span class="icon has-text-info"><i class="far fa-edit"></i></span>
                            <span>ユーザー新規登録</span>
                        </a>
                    <?php endif; ?>
                </div>

                <!-- ログイン or ログアウト -->
                <div class="navbar-item">
                    <?php if (isset($_SESSION['user'])): ?>
                        <a href="./user-logout.php" class="is-flex is-align-items-center">
                            <span class="icon has-text-info"><i class="fas fa-sign-out-alt"></i></span>
                            <span>ログアウト</span>
                        </a>
                    <?php else: ?>
                        <a href="./user-login.php" class="is-flex is-align-items-center">
                            <span class="icon has-text-info"><i class="fas fa-sign-in-alt"></i></span>
                            <span>ログイン</span>
                        </a>
                    <?php endif; ?>
                </div>
                <div class="navbar-item">
                    <a href="./provider-index.php" class="is-flex is-align-items-center">
                        <span class="icon has-text-info"><i class="fas fa-user-cog"></i></span>
                        <span>提供者</span>
                    </a>
                </div>
            </div>
        </div>
    </nav>
<!-- ✅ 検索フォーム -->
        <div class="level-item" v-if="isSearchActive" style="position: absolute; width: 520px; text-align: center; margin:20px auto 0;">
        <form class="box" style="width: 520px; text-align: center;" action="search.php" method="post">
            <!-- キーワード検索 -->
            <div class="columns is-gapless">
                <div class="column is-narrow is-flex is-align-items-center">
                    <span class="icon has-text-info"><i class="fas fa-search"></i></span>
                    <span>検索</span>
                </div>
                <div class="column">
                    <input class="input" type="text" name="searchWord" placeholder="キーワードを入力してください">
                </div>
            </div>

            <hr>
            <!-- タグ検索 -->
            <div class="field is-grouped">
                <?php foreach ($tags as $tag): ?>
                    <div class="control">
                        <label class="checkbox">
                            <input type="checkbox" name="tags[]" value="<?= htmlspecialchars($tag['tagid']) ?>">
                            <?= htmlspecialchars($tag['tag_name']) ?>
                        </label>
                    </div>
                <?php endforeach; ?>
            </div>

            <hr>
            
            <!-- 開催日検索 -->
            <div class="field">
                <label class="label">開催日</label>
                <div class="control">
                    <input class="input" type="date" name="start_date">
                </div>
                <div class="control">
                    <input class="input" type="date" name="end_date">
                </div>
            </div>

            <hr>

            <!-- 開催地検索 -->
            <div class="field">
                <label class="label">開催地</label>
                <div class="control">
                    <select class="input" name="event_location">
                        <option value="" selected>すべて</option>
                        <option value="北海道">北海道</option>
                        <option value="東北">東北</option>
                        <option value="関東">関東</option>
                        <option value="中部">中部</option>
                        <option value="関西">関西</option>
                        <option value="中国">中国</option>
                        <option value="四国">四国</option>
                        <option value="九州・沖縄">九州・沖縄</option>
                    </select>
                </div>
            </div>

            <hr>

            <!-- 開催期間検索 -->
            <div class="field">
                <label class="label">開催期間</label>
                <div class="control">
                    <select class="input" name="event_duration">
                        <option value="" selected>すべて</option>
                        <option value="日帰り">日帰り</option>
                        <option value="2日以上">2日以上</option>
                        <option value="1週間以上">1週間以上</option>
                    </select>
                </div>
        </form>
    </div>
</div>

    <script src="https://cdn.jsdelivr.net/npm/vue@2.7.14/dist/vue.js"></script>
    <script src="script/navigation-script.js"></script>
</div>
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
                    <a id="search" class="is-flex is-align-items-center">
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
            </div>
        </div>
    </nav>
</div>
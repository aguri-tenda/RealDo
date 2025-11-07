<div id="app-navigation">
    <div>
        <div class="navbar" id="app-navigation">
            <div class="navbar-brand">
                <a href="index.php">
                    <div class="image" style="width: 170px; height: auto;">
                        <img src="img/logo.png" alt="RealDo">
                    </div>
                </a>

                <!-- ✅ ハンバーガーメニュー -->
                <a role="button" class="navbar-burger" :class="{ 'is-active': isMenuActive }" aria-label="menu"
                    aria-expanded="false" @click="toggleMenu">
                    <span aria-hidden="true"></span>
                    <span aria-hidden="true"></span>
                    <span aria-hidden="true"></span>
                </a>
            </div>

            <div class="navbar-menu app-navigation">

                <div class="navbar-end">
                    <div class="navbar-item">
                        <a id="search">
                            <div>
                                <div class="icon"><i class="fas fa-search"></i></div>
                                <div>検索</div>
                            </div>
                        </a>
                    </div>

                    <div class="navbar-item">
                        <?php if (isset($_SESSION['user'])): ?>
                            <a href="./userUpdate.php">
                                <div>
                                    <div class="icon"><i class="far fa-edit"></i></div>
                                    <div>ユーザー情報更新</div>
                                </div>
                            </a>
                        <?php else: ?>
                            <a href="./userInsert.php">
                                <div>
                                    <div class="icon"><i class="far fa-edit"></i></div>
                                    <div>ユーザー新規登録</div>
                                </div>
                            </a>
                        <?php endif; ?>
                    </div>


                    <div class="navbar-item">
                        <?php if (isset($_SESSION['user'])): ?>
                            <a href="./user-logout.php">
                                <div>
                                    <div class="icon"><i class="fas fa-sign-out-alt"></i></div>
                                    <div>ログアウト</div>
                                </div>
                            </a>
                        <?php else: ?>
                            <a href="./user-login.php">
                                <div>
                                    <div class="icon"><i class="fas fa-sign-in-alt"></i></div>
                                    <div>ログイン</div>
                                </div>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <hr style="border: 1px solid #278EDD;">
</div>
<script src="script/navigation-script.js"></script>
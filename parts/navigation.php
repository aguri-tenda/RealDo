<!--ヘッダー-->
<div>
    <!-- ナビゲーション -->
    <div class="navbar" id="app-navigation">

            <!--サイトロゴ-->
            <div class="navbar-brand">
                <div class="image" style="width: 170px; height: auto;">
                    <a href="index.php">
                    <div class="image is-3200x1800">
                        <img src="img/logo.png" alt="RealDo">
                    </div>
                    </a>
                </div>
            </div>
        </div>

        <!--メニュー-->
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
                    <div v-if=" condition ">
                        <a href="./userInsert.php">
                            <div>
                                <div class="icon"><i class="far fa-edit"></i></div>
                                <div>ユーザー新規登録</div>
                            </div>
                        </a>
                    </div>
                    <div v-else=" condition ">
                        <a href="./userUpdate.php">
                            <div>
                                <div class="icon"><i class="far fa-edit"></i></div>
                                <div>ユーザー情報更新</div>
                            </div>
                        </a>
                    </div>
                </div>


                <div class="navbar-item">

                    <div v-if=" condition ">
                        <a href="./log-in.php">
                            <div>
                                <div class="icon"><i class="fas fa-sign-in-alt"></i></div>
                                <div v-if=" condition ">ログイン</div>
                            </div>
                        </a>
                    </div>
                    <div v-else=" condition ">
                        <a href="./log-out.php">
                            <div>
                                <div class="icon"><i class="fas fa-sign-out-alt"></i></div>
                                <div v-if=" condition ">ログアウト</div>
                            </div>
                        </a>
                    </div>

                </div>
            </div>

        </div>
    </div>

    <hr>

    <script src="https://cdn.jsdelivr.net/npm/vue@2.7.11/dist/vue.js"></script>
    <script src="script/navigation-script.js"></script>
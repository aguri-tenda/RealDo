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
    <div id="search-modal" class="modal" :class="{ 'is-active': isSearchActive }">
        <div class="modal-background" @click="toggleSearch"></div>
        
        <div class="modal-content is-medium">
            <div class="box">
                <h3 class="title is-4 has-text-centered">🔍 検索</h3>
                <div class="tabs is-boxed is-fullwidth">
                    <ul>
                        <li class="is-active"><a>商品名検索</a></li>
                        <li><a>タグ名検索</a></li>
                    </ul>
                </div>

                <div class="field">
                    <label class="label">商品名</label>
                    <div class="control">
                        <input class="input" type="text" placeholder="商品名を入力">
                    </div>
                </div>
                
                <div class="field">
                    <label class="label">開催日</label>
                    <div class="field is-grouped">
                        <p class="control is-expanded">
                            <input class="input" type="text" placeholder="開始日 20xx/**/**">
                        </p>
                        <p class="control">〜</p>
                        <p class="control is-expanded">
                            <input class="input" type="text" placeholder="終了日 20xx/**/**">
                        </p>
                    </div>
                </div>

                <div class="field">
                    <label class="label">開催地</label>
                    <div class="control">
                        <div class="select is-fullwidth">
                            <select>
                                <option>都道府県を選択</option>
                                <option>〇〇県</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="field">
                    <label class="label">開催期間</label>
                    <div class="control">
                        <div class="select is-fullwidth">
                            <select>
                                <option>期間を選択</option>
                                <option>日帰り</option>
                                <option>1泊2日</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="field is-grouped is-grouped-centered">
                    <p class="control">
                        <button class="button is-info is-large" disabled>検索</button>
                    </p>
                    <p class="control">
                        <button class="button is-light is-large" @click="toggleSearch">閉じる</button>
                    </p>
                </div>
            </div>
        </div>
        
        <button class="modal-close is-large" aria-label="close" @click="toggleSearch"></button>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/vue@2.7.14/dist/vue.js"></script>
    <script src="script/navigation-script.js"></script>
</div>
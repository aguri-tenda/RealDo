Vue.component('rating-selector', {
    template: `
        <div class="rating-stars-container" :class="{ 'disabled-rating': isDisabled }">
            <span
                v-for="star in 5"
                :key="star"
                :class="{ 'star-filled': star <= displayRating }"
                @click="setRating(star)"
                @mouseover="handleMouseOver(star)"
                @mouseleave="handleMouseLeave"
                class="star-icon"
            >
                {{ star <= displayRating ? '★' : '☆' }}
            </span>
        </div>
    `,
    props: {
        // 親コンポーネントから受け取る評価値（文字列で渡されるのでNumberに変換）
        rating: {
            type: [String, Number],
            default: 0
        },
        // 親コンポーネントから受け取る無効化フラグ
        disabled: {
            type: [String, Boolean],
            default: false
        }
    },
    data() {
        return {
            // 親から渡された評価値（rating prop）を初期値として使用
            currentRating: Number(this.rating), 
            hoverRating: 0    // マウスオーバー中の評価 (1〜5)
        };
    },
    computed: {
        // 星の表示を制御する値 (ホバー中ならホバー値、そうでなければ現在の評価値)
        displayRating() {
            // disabledの場合はhoverRatingを無視
            return this.isDisabled ? this.currentRating : (this.hoverRating || this.currentRating);
        },
        // disabledプロパティをBooleanとして正しく評価
        isDisabled() {
            return this.disabled === true || this.disabled === 'true';
        }
    },
    methods: {
        setRating(rating) {
            // disabledモードなら何もしない
            if (this.isDisabled) return; 

            this.currentRating = rating;
            
            // 隠しフィールドに選択された評価値をセット (insert画面でのみ有効)
            // complete画面にはhiddenフィールドもありますが、ここでは変更しない
            const ratingValueElement = document.getElementById('rating-value');
            if (ratingValueElement) {
                ratingValueElement.value = rating;
            }
        },
        handleMouseOver(star) {
            // disabledモードなら何もしない
            if (this.isDisabled) return;
            this.hoverRating = star;
        },
        handleMouseLeave() {
            // disabledモードなら何もしない
            if (this.isDisabled) return;
            this.hoverRating = 0;
        }
    },
    // マウント時の処理を追加 (hiddenフィールドの初期値をpropsから受け取った値に設定)
    mounted() {
        if (!this.isDisabled) {
            // insert画面の場合、初期値(rating prop)をhiddenフィールドに設定（念のため）
            const ratingValueElement = document.getElementById('rating-value');
            if (ratingValueElement) {
                ratingValueElement.value = this.currentRating;
            }
        }
    }
});

// Vueアプリケーションのインスタンス化 (変更なし)
new Vue({
    el: '#vue-rating-app'
});

// 星のスタイル設定（CSS）
const style = document.createElement('style');
style.textContent = `
    .rating-stars-container {
        /* 既存のスタイル ... */
        font-size: 2.5rem; 
        color: orange;     
        cursor: pointer; /* 通常時はポインター */
        user-select: none;
        letter-spacing: 0.2rem; 
        display: flex;
        justify-content: center;
        align-items: center;
    }
    /* disabledクラスが適用された場合、カーソルを変更 */
    .disabled-rating {
        cursor: default !important; /* 編集不可の場合はデフォルトカーソル */
    }
    .star-icon {
        transition: color 0.2s;
    }
    /* ... 既存のスタイル ... */
`;
document.head.appendChild(style);
Vue.component('rating-selector', {
    template: `
        <div class="rating-stars-container">
            <span
                v-for="star in 5"
                :key="star"
                :class="{ 'star-filled': star <= currentRating % 6 }"
                @click="setRating(star)"
                @mouseover="hoverRating = star"
                @mouseleave="hoverRating = 0"
                class="star-icon"
            >
                {{ star <= (hoverRating || currentRating) ? '★' : '☆' }}
            </span>
        </div>
    `,
    data() {
        return {
            currentRating: 0, // 現在選択されている評価 (1〜5)
            hoverRating: 0    // マウスオーバー中の評価 (1〜5)
        };
    },
    methods: {
        setRating(rating) {
            this.currentRating = rating;
            // 隠しフィールドに選択された評価値をセット
            document.getElementById('rating-value').value = rating;
        }
    }
});

// Vueアプリケーションのインスタンス化
new Vue({
    el: '#vue-rating-app'
});

// 星のスタイル設定（CSS）
const style = document.createElement('style');
style.textContent = `
    .rating-stars-container {
        font-size: 2.5rem; /* 星のサイズを調整 */
        color: orange;     /* 星の色をオレンジに設定 */
        cursor: pointer;
        user-select: none;
        letter-spacing: 0.2rem; /* 星と星の間隔を調整 */
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .star-icon {
        transition: color 0.2s;
    }
    /* 塗りつぶされた星（★）のスタイル（ここでは色で表現） */
    .star-filled {
        /* すでに色の指定があるので、特にclassで色を変える必要はありませんが、
           星の見た目をカスタマイズしたい場合はここで設定します。
           ここでは、★と☆を使い分けているので、追加のCSSは不要です。
        */
    }
`;
document.head.appendChild(style);
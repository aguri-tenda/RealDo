// ------------------------------------------------------------------
// 1. 参加者フォーム（ParticipantBox）コンポーネントの定義
// ------------------------------------------------------------------
const ParticipantBox = {
    // 親コンポーネント（App）から参加者番号（index）を受け取る
    props: ['index'],

    // テンプレートを定義 (HTMLの変更はここで行う)
    template: `
        <div class="participant-box">

            <label class="label" style="color: #278EDD; margin-bottom: 15px; font-size: 1.2rem;">
                参加者 {{ index }}
            </label>

            <div class="field is-horizontal mb-4">
                <div class="field-label is-normal" style="width: 150px;">
                    <label class="label" style="color: #278EDD;">参加者氏名</label>
                </div>

                <div class="field-body">
                    <div class="field">
                        <input class="input" type="text" style="width: 250px;" name="name[]" placeholder="田中 太郎" required>
                    </div>

                    <div class="field-label is-normal" style="margin-left: 30px; width: 120px;">
                        <label class="label" style="color: #278EDD;">フリガナ</label>
                    </div>

                    <div class="field">
                        <input class="input" type="text" style="width: 300px;" name="kana[]" placeholder="タナカ タロウ" required>
                    </div>
                </div>
            </div>

            <div class="field is-horizontal mb-4">
                <div class="field-label is-normal" style="width: 150px;">
                    <label class="label" style="color: #278EDD;">電話番号（TEL）</label>
                </div>

                <div class="field-body">
                    <div class="field">
                        <input class="input" type="tel" style="width: 250px;" name="tel[]"
                            placeholder="00000000000" required pattern="[0-9]{10,11}">
                    </div>
                </div>
            </div>
            <hr style="margin: 25px 0;">
        </div>
    `
};

const BookingApp = new Vue({
    el: "#app-booking",

    components: {
        'participant-box': ParticipantBox
    },

    data: {
        participants: 1
    },
});
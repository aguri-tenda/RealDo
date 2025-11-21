const App = new Vue({
  el: "#app-booking-confirm",
  data: {
    participants: 1
  },
  methods: {
    participantBoxTemplate() {
        return `
            <!-- 参加者の入力欄（テンプレ） -->
            <div class="participant-box">

                <!-- 氏名・フリガナ -->
                <div class="field is-horizontal mb-4">
                    <div class="field-label is-normal" style="width: 150px;">
                        <label class="label" style="color: #278EDD;">参加者氏名</label>
                    </div>

                    <div class="field-body">
                        <div class="field">
                            <input class="input" type="text" style="width: 250px;" name="name[]" placeholder="田中 太郎">
                        </div>

                        <div class="field-label is-normal" style="margin-left: 30px; width: 120px;">
                            <label class="label" style="color: #278EDD;">フリガナ</label>
                        </div>

                        <div class="field">
                            <input class="input" type="text" style="width: 300px;" name="kana[]" placeholder="タナカ タロウ">
                        </div>
                    </div>
                </div>

                <!-- 電話番号 -->
                <div class="field is-horizontal mb-4">
                    <div class="field-label is-normal" style="width: 150px;">
                        <label class="label" style="color: #278EDD;">電話番号（TEL）</label>
                    </div>

                    <div class="field-body">
                        <div class="field">
                            <input class="input" type="text" style="width: 250px;" name="tel[]"
                                placeholder="00000000000">
                        </div>
                    </div>
                </div>
                <hr style="margin: 25px 0;">
            </div>
        </div>
        `;
    }
  },

  computed: {
    participantBoxes() {
        let boxes = '';
        for (let i = 0; i < this.participants; i++) {
            boxes += this.participantBoxTemplate();
        }
        return boxes;
    }
  }
});
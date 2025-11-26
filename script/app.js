//読み込み完了後に実行する
$(function() {
    //#btnがクリックされたとき
    $('#getAddress').on('click', function(){
        $.ajax({
            //リクエスト先のURLを設定
            url: "https://zipcloud.ibsnet.co.jp/api/search?zipcode=" + $('#zipcode').val(),

            //レスポンスのデータ形式を設定
            dataType : 'jsonp',

        }).done(function(data){
            //通信が成功したときの処理
            if(data.results){
                //データが取得できたとき、setData関数を呼び出す
                setData(data.results[0]);
            }else{
                alert("該当するデータが見つかりませんでした");
            }
        }).fail(function(data){
            //通信が失敗したときの処理
            alert("通信に失敗しました");
        });
    });
});

function setData(data){
    //取得データを各HTML要素に代入
    $('#address').val(data.address1 + data.address2 + data.address3);

}
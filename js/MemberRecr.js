$(function(){
    //テキストリンクをクリックしたら
    $("#modal-open").click(function(){
        //body内の最後に<div id="modal-bg"></div>を挿入
        $("body").append('<div id="modal-bg"></div>');
        //画面中央を計算する関数を実行
        modalResize();
        //モーダルウィンドウを表示
        $("#modal-bg,#form").fadeIn("slow");

        //画面のどこかをクリックしたらモーダルを閉じる
        $("#modal-bg").click(function(){
            $("#form,#modal-bg").fadeOut("slow",function(){
                //挿入した<div id="modal-bg"></div>を削除
                $('#modal-bg').remove() ;
            });
        });
        //画面の左上からmodal-mainの横幅・高さを引き、その値を2で割ると画面中央の位置が計算できます
        $(window).resize(modalResize);
        function modalResize(){

            var w = $(window).width();
            var h = $(window).height();

            var cw = $("#form").outerWidth();
            var ch = $("#form").outerHeight();

            //取得した値をcssに追加する
            $("#form").css({
                "left": ((w - cw)/2) + "px",
                "top": ((h - ch)/2) + "px"
            });
        }
    });

    //方針で探すモーダルの内容
    $("#tag-open").click(function(){
        //body内の最後に<div id="modal-bg"></div>を挿入
        $("body").append('<div id="modal-bg"></div>');
        $("body").append('<div id="modal-detail"></div>');

        //画面中央を計算する関数を実行
        modalResize();
        //モーダルウィンドウを表示
        $("#modal-bg,#modal-detail").fadeIn("slow");
        $("#modal-detail").append(
            "<div id='search'>" +
            "<h2>方針で探す</h2>" +
            "<div id='searchTags'>" +
            "<p class='searchTag'></p>" +
            "</div>" +
            "</div>"
        );

        //画面のどこかをクリックしたらモーダルを閉じる
        $("#modal-bg").click(function(){
            $("#modal-bg").fadeOut("slow",function(){
                //挿入した<div id="modal-bg"></div>を削除
                $('#modal-bg,#modal-detail').remove() ;
            });
        });
        //画面の左上からmodal-mainの横幅・高さを引き、その値を2で割ると画面中央の位置が計算できます
        $(window).resize(modalResize);
        function modalResize(){

            var w = $(window).width();
            var h = $(window).height();

            var cw = $("#form").outerWidth();
            var ch = $("#form").outerHeight();

            //取得した値をcssに追加する
            $("#form").css({
                "left": ((w - cw)/2) + "px",
                "top": ((h - ch)/2) + "px"
            });
        }
    });

    //テンプレート自動入力
    $("#callTemp").click(function(){
        //入力値を取得
        var teamname = $("#tempTeamName").text()
        var ID = $("#tempGameID").text()
        var cont = $("#tempCont").text()
        var member = $("#tempMember").text()
        var AT1 = $("#tempAT1").text()
        var AT2 = $("#tempAT2").text()
        var tags = $("#tempTag").text()
        var tagList = tags.split(",")

        //該当する値に自動入力
        $("#TeamName").val(teamname)
        $("#GameId").val(ID)
        $("#RecrCont").val(cont)
        $("#member").val(member)
        $("#AT1").val(AT1)
        $("#AT2").val(AT2)
        var tagBox = document.getElementsByName("tag[]");
        var cnt = tagBox.length;

        console.log(tagList)


        $.each(tagList,function (tag,t) {
            console.log(tag+':'+t);
            for(var i = 0;i<=cnt;i++){
                if(i == t){
                    var check = $('input[name="tag[]"]');
                    check.eq(i-1).prop("checked",true);
                }
            }
        })
    })
});

function copyText(text){
    var ta = document.createElement("textarea")
    ta.value = text
    document.body.appendChild(ta)
    ta.select()
    document.execCommand("copy")
    ta.parentElement.removeChild(ta)

    var alert = document.getElementById("alertCopy");
    alert.style.opacity="1";
    var fadeout = function(){
        alert.style.opacity ="0"
    };
    setTimeout(fadeout,3000);
}



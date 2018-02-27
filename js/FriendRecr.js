/**
 * Created by sugamasataka on 2018/02/03.
 */
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

    //方針で探すモーダル
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
        var TitleF = $("#tempTitle").text()
        var idF = $("#tempGameID").text()
        var contF = $("#tempCont").text()
        var fire =$("#tempFire").text()
        var water =$("#tempWater").text()
        var earth =$("#tempEarth").text()
        var wind =$("#tempWind").text()
        var light =$("#tempLight").text()
        var dark =$("#tempDark").text()
        var free1 =$("#tempFree1").text()
        var free2 =$("#tempFree2").text()



        //該当する値に自動入力
        $("#FRecrTitle").val(TitleF)
        $("#GameId").val(idF)
        $("#FRecrCont").val(contF)
        if(!(fire == "未設定")){
            var firesplit = fire.split('：')
            console.log(firesplit[0])
            $("#Fire").val(firesplit[0])
            $("#FireState").val(firesplit[1])
        }
        if(!(water == "未設定")){
            var watersplit = water.split('：')
            console.log(watersplit[0])
            $("#Water").val(watersplit[0])
            $("#WaterState").val(watersplit[1])
        }
        if(!(earth == "未設定")){
            var earthsplit = earth.split('：')
            console.log(earthsplit[0])
            $("#Earth").val(earthsplit[0])
            $("#EarthState").val(earthsplit[1])
        }
        if(!(wind == "未設定")){
            var windsplit = wind.split('：')
            console.log(windsplit[0])
            $("#Wind").val(windsplit[0])
            $("#WindState").val(windsplit[1])
        }
        if(!(light == "未設定")){
            var lightsplit = light.split('：')
            console.log(lightsplit[0])
            $("#Light").val(lightsplit[0])
            $("#LightState").val(lightsplit[1])
        }
        if(!(dark == "未設定")){
            var darksplit = dark.split('：')
            console.log(darksplit[0])
            $("#Dark").val(darksplit[0])
            $("#DarkState").val(darksplit[1])
        }
        if(!(free1 == "未設定")){
            var free1split = free1.split('：')
            console.log(free1split[0])
            $("#Free1").val(free1split[0])
            $("#Free1State").val(free1split[1])
        }
        if(!(free2 == "未設定")){
            var free2split = free2.split('：')
            console.log(free2split[0])
            $("#Free2").val(free2split[0])
            $("#Free2State").val(free2split[1])
        }

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



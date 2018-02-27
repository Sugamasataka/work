$(function(){
//登録するを押した時に編集画面に切り替える
    $("#registerFriend").click(function(){

        //メッセージを非表示
        $("#friendTemplate").hide()

        $("#friendForm").show()

        //キャンセルを押した時に元のメッセージを表示(入力フォームを非表示)
        $("#cancelBtn").click(function(){
            $('#friendForm').hide() ;
            $("#friendTemplate").show();
        });
    });

    $("#registerMember").click(function(){

        //メッセージを非表示
        $("#memberTemplate").hide()

        $("#MemberForm").show()

        //キャンセルを押した時に元のメッセージを表示(入力フォームを非表示)
        $("#cancelBtnMT").click(function(){
            $('#MemberForm').hide() ;
            $("#memberTemplate").show();
        });
    });

    $("#editBtnFriend").click(function(){

        var TitleF = $("#tempTitleF").text()
        var idF = $("#tempIDF").text()
        var contF = $("#tempContF").text()
        var fire =$("#fire").text()
        var water =$("#water").text()
        var earth =$("#earth").text()
        var wind =$("#wind").text()
        var light =$("#light").text()
        var dark =$("#dark").text()
        var free1 =$("#free1").text()
        var free2 =$("#free2").text()
        var email =$("#email").text()

        //メッセージを非表示
        $("#friendTemplate").hide()

        $("#friendForm").show()

        $("#FRecrTitle").val(TitleF)
        $("#GameIdF").val(idF)
        $("#FRecrCont").val(contF)
        $("#Frecremail").val(email)
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


        //キャンセルを押した時に元のメッセージを表示(入力フォームを非表示)
        $("#cancelFT").click(function(){
            $('#friendForm').hide() ;
            $("#friendTemplate").show();
        });
    });

    $("#editBtnMember").click(function(){

        var teamname = $("#tempTitleR").text()
        var ID = $("#tempIDM").text()
        var contM = $("#tempContM").text()
        var member = $("#tempMember").text()
        var AT1 = $("#tempAssault1").text()
        var AT2 = $("#tempAssault2").text()
        var tagList =[]
        tagList = $(".tagName").map(function(){
            return $(this).text();
        }).get();

        //メッセージを非表示
        $("#memberTemplate").hide()
        $("#MemberForm").show()

        $("#TeamName").val(teamname)
        $("#GameIdM").val(ID)
        $("#RecrCont").val(contM)
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

        $("#cancelMT").click(function(){
            $('#MemberForm').hide() ;
            $("#memberTemplate").show();
        });
    });

    //クリックしたときのファンクションをまとめて指定
    $('.tab li').click(function () {

        //.index()を使いクリックされたタブが何番目かを調べ、
        //indexという変数に代入します。
        var index = $('.tab li').index(this);
        //コンテンツを一度すべて非表示にし、
        $('.template').css('display', 'none');
        //クリックされたタブと同じ順番のコンテンツを表示します。
        $('.template').eq(index).css('display', 'block');
        //一度タブについているクラスselectを消し、
        $('.tab li').removeClass('select');
        //クリックされたタブのみにクラスselectをつけます。
        $(this).addClass('select')
    });

});


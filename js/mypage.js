$(function(){
    //編集を押した時に編集画面に切り替える
    $("#editBtn").click(function(){
        //プロフィールの内容を取得
        var name = $(".name").text()
        var prof = $(".profile").text()
        var src = $(".iconImage").attr('src');
        var id = $(".id").text()
        console.log(name)
        console.log(prof)
        console.log(src)
        console.log(id)

        //プロフィールを非表示
        $("#profile").hide()

        //非表示の箇所に入力フォームを追加
        $("#profileBox").append("<div id='editProf'></div>")
        $("#editProf").append(
            "<form action='process/editProfile.php' method='post' id='editForm'>" +
                "<div>" +
                    "<div id='IconBox'>" +
                        "<img id='Icon' src='' alt=''>" +
                        "<input id='editIcon' type='hidden' name='editIcon'>" +
                        "<div class='mask'>"+
                            "<div class='caption'>編集</div>"+
                        "</div>" +
                    "</div>" +

                    "<div class='profName'>" +
                        "<p class='profTitle'>アカウント名</p>" +
                        "<input type='text' id='editName' name='editName'>" +
                    "</div>" +
                    "<div class='profProfile'>" +
                        "<p class='profTitle'>自己紹介</p>" +
                        "<textarea name='editProf' id='editProfile' cols='20' rows='10'></textarea>" +
                    "</div>" +
                        "<input type='hidden' id='editID' name='editID'>" +
                    "<div id='BtnList'>" +
                        "<input class='btn' id='formData' type='submit' value='変更を保存'>" +
                        "<p id='cancelBtn' class='btn'>キャンセル</p>" +
                    "</div>" +
                "</div>"+
            "</form>"
        )

        //フォーム内容にプロフィール情報を入れる
        $("#editName").val(name)
        $('textarea[name="editProf"]').val([prof])
        $('#Icon').attr('src',src)
        $('#editIcon').val(src)
        $('#editID').val(id)

        //キャンセルを押した時に元のプロフィールを表示(入力フォームを削除)
        $("#cancelBtn").click(function(){
                //挿入した<div id='editProf'></div>を削除
                $('#editProf').remove() ;
                $("#profile").show();
        });

        $("#IconBox").click(function (){
            //body内の最後に<div id="modal-bg"></div>を挿入
            $("body").append('<div id="modal-bg"></div>');
            //画面中央を計算する関数を実行
            modalResize();
            //モーダルウィンドウを表示
            $("#modal-bg,#selectIcon").fadeIn("slow");

            //画面のどこかをクリックしたらモーダルを閉じる
            $("#cancelIcon").click(function(){
                $("#selectIcon,#modal-bg").fadeOut("slow",function(){
                    //挿入した<div id="modal-bg"></div>を削除
                    $('#modal-bg').remove() ;
                });
            });

            //画面のどこかをクリックしたらモーダルを閉じる
            $("#modal-bg").click(function(){
                $("#selectIcon,#modal-bg").fadeOut("slow",function(){
                    //挿入した<div id="modal-bg"></div>を削除
                    $('#modal-bg').remove() ;
                });
            });
            //画面の左上からmodal-mainの横幅・高さを引き、その値を2で割ると画面中央の位置が計算できます
            $(window).resize(modalResize);
            function modalResize(){

                var w = $(window).width();
                var h = $(window).height();

                var cw = $("#selectIcon").outerWidth();
                var ch = $("#selectIcon").outerHeight();

                //取得した値をcssに追加する
                $("#selectIcon").css({
                    "left": ((w - cw)/2) + "px",
                    "top": ((h - ch)/2) + "px"
                });
            }
        });

        $(function(){
            // クラス選択
            $('.icon').click(function(){
                var index = $('.icon').index(this);
                var image = $('.image').eq(index).attr('src');
                $('.image').removeClass('selected')
                $('.image').eq(index).addClass('selected')

                $('#Decide').click(function(){
                    var select = $('.selected').attr('src')

                    $('#Icon').attr('src',select)
                    $('#editIcon').val(select)

                    $("#selectIcon,#modal-bg").fadeOut("slow",function(){
                        //挿入した<div id="modal-bg"></div>を削除
                        $('#modal-bg').remove() ;
                    });
                })
            });

        });


    });


});


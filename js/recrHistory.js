$(function () {

    //クリックしたときのファンクションをまとめて指定

    $('.tab li').click(function () {

        //.index()を使いクリックされたタブが何番目かを調べ、
        //indexという変数に代入します。
        var index = $('.tab li').index(this);
        //コンテンツを一度すべて非表示にし、
        $('.cardList').css('display', 'none');
        //クリックされたタブと同じ順番のコンテンツを表示します。
        $('.cardList').eq(index).css('display', 'block');
        //一度タブについているクラスselectを消し、
        $('.tab li').removeClass('select');
        //クリックされたタブのみにクラスselectをつけます。
        $(this).addClass('select')
    });

    $(document).ready(function () {
        /**
         * 送信ボタンクリック
         */
        $('.detailMember').click(function () {
            // POSTメソッドで送るデータを定義します var data = {パラメータ名 : 値};
            var index = $('.detailMember').index(this);
            var MRid = $('.MRid').eq(index).val();
            console.log(MRid);
            /**
             * Ajax通信メソッド
             * @param type  : HTTP通信の種類
             * @param url   : リクエスト送信先のURL
             * @param data  : サーバに送信する値
             */
            event.preventDefault();
            $.ajax({
                type: "POST",
                url: "/shupre/process/MemberRecruitDetail.php",
                data: {'MRid': MRid},
                dataType: "json",
            }).done(function (result, dataType) {

                // successのブロック内は、Ajax通信が成功した場合に呼び出される
                // PHPから返ってきたデータの表示

                console.log(result);
                //body内の最後に<div id="modal-bg"></div>を挿入
                $("body").append('<div id="modal-bg"></div>');
                $("body").append('<div id="modal-detail"></div>');

                //画面中央を計算する関数を実行
                modalResize();

                //モーダルウィンドウを表示
                $("#modal-bg,#modal-detail").fadeIn("slow");

                $("#modal-detail").append(
                    "<div id='detailContents'>" +

                        "<div id='detailTeamName'>" +
                            "<p>" + result.TeamName + "</p>" +
                        "</div>" +

                        "<div id='detailContributor'>" +
                            "<p class='cont'>投稿者</p>" +
                            "<p>" + result.Contributor + "</p>" +
                        "</div>" +

                        "<div id='detailLeft'>" +
                            "<div id='detailCont'>" +
                                "<p class='cont'>募集内容</p>" +
                                "<p class='resultCont'>" + result.cont + "</p>" +
                            "</div>" +
                        "</div>" +

                        "<div id='detailRight'>" +
                            "<div id='detailTags'>" +
                                "<p id=''>団の方針</p>" +
                                "<div id='tagBox'>" +
                                "</div>" +
                            "</div>" +
                            "<div id='detailAt'>" +
                                "<p class='cont'>アサルトタイム</p>" +
                                "<p class='resultAt'>" + result.AT1 + "</p>" +
                                "<p class='resultAt'>" + result.AT2 + "</p>" +
                            "</div>" +
                            "<div id='detailGameID'>" +
                                "<p class='cont'>ゲームID</p>" +
                                "<p class='resultGameID'>" + result.GameID + "</p>" +
                            "</div>" +
                        "</div>" +

                        "<div id='detailDate'>" +
                            "<p class='cont'>投稿日時</p>" +
                            "<p>" + result.recrDate + "</p>" +
                        "</div>" +

                        "<form action='process/deleteMember.php' method='post'>" +
                            "<input type='hidden' name='MRid' value='" + result.id + "'>" +
                            "<input id='deleteRecr' class='deleteBtn' type='submit' value='募集を締め切る'>" +
                        "</form>" +
                    "</div>"
                );

                //方針(タグ)を一つずつ表示
                for (var i = 0; i < result.tag.length; i++) {
                    $("#tagBox").append("<p class='detailTag'>" + result.tag[i] + "</p>");

                }
                //画面のどこかをクリックしたらモーダルを閉じる
                $("#modal-bg").click(function () {
                    $("#modal-detail,#modal-bg").fadeOut("slow", function () {
                        //挿入した<div id="modal-bg"></div>を削除
                        $('#modal-bg').remove();
                        $('#modal-detail').remove();
                    });
                });
                //画面の左上からmodal-mainの横幅・高さを引き、その値を2で割ると画面中央の位置が計算できます
                $(window).resize(modalResize);
                function modalResize() {

                    var w = $(window).width();
                    var h = $(window).height();

                    var cw = $("#modal-detail").outerWidth();
                    var ch = $("#modal-detail").outerHeight();
                    var sh = screen.availHeight;

                    //取得した値をcssに追加する
                    $("#modal-detail").css({
                        "left": ((w - cw) / 2) + "px",
                        "top": ((h - ch) / 2) + "px"
                    });
                }
            }).fail(function (XMLHttpRequest, textStatus, errorThrown) {
                // 通常はここでtextStatusやerrorThrownの値を見て処理を切り分けるか、単純に通信に失敗した際の処理を記述します。

                // this;
                // thisは他のコールバック関数同様にAJAX通信時のオプションを示します。

                // エラーメッセージの表示
                alert('Error : ' + errorThrown);
            });
            // サブミット後、ページをリロードしないようにする
            return false;
        });
    });

    $(document).ready(function () {
        /**
         * 送信ボタンクリック
         */
        $('.detailFriend').click(function () {
            // POSTメソッドで送るデータを定義します var data = {パラメータ名 : 値};
            var index = $('.detailFriend').index(this);
            var FRid = $('.FRid').eq(index).val();
            console.log(FRid);
            /**
             * Ajax通信メソッド
             * @param type  : HTTP通信の種類
             * @param url   : リクエスト送信先のURL
             * @param data  : サーバに送信する値
             */
            event.preventDefault();
            $.ajax({
                type: "POST",
                url: "/shupre/process/FriendRecruitDetail.php",
                data: {'FRid': FRid},
                dataType: "json",
            }).done(function (result, dataType) {

                // successのブロック内は、Ajax通信が成功した場合に呼び出される
                // PHPから返ってきたデータの表示

                console.log(result);
                //body内の最後に<div id="modal-bg"></div>を挿入
                $("body").append('<div id="modal-bg"></div>');
                $("body").append('<div id="modal-detail"></div>');

                //画面中央を計算する関数を実行
                modalResize();

                //モーダルウィンドウを表示
                $("#modal-bg,#modal-detail").fadeIn("slow");

                $("#modal-detail").append(
                    "<div id='detailContents'>" +

                        "<div id='detailTeamName'>" +
                            "<p>" + result.Title + "</p>" +
                        "</div>" +
                        "<div id='detailContributor'>" +
                            "<p class='cont'>投稿者</p>" +
                            "<p>" + result.Contributor + "</p>" +
                        "</div>" +
                        "<div id='detailLeft'>" +
                            "<div id='detailCont'>" +
                                "<p class='cont'>募集内容</p>" +
                                "<p class='resultCont'>" + result.cont + "</p>" +
                            "</div>" +
                        "</div>" +
                    "<div id='detailRight'>" +
                        "<div id='detailSummonBox'>" +
                            "<p>サポーター専用召喚石一覧</p>" +
                            "<div class='detailSummon'>" +
                                "<p>火属性</p>" +
                                "<p>" + result.flame + "</p>" +
                            "</div>" +
                            "<div class='detailSummon'>" +
                                "<p>水属性</p>" +
                                "<p>" + result.water + "</p>" +
                            "</div>" +
                            "<div class='detailSummon'>" +
                                "<p>土属性</p>" +
                                "<p>" + result.earth + "</p>" +
                            "</div>" +
                            "<div class='detailSummon'>" +
                                "<p>風属性</p>" +
                                "<p>" + result.wind + "</p>" +
                            "</div>" +
                            "<div class='detailSummon'>" +
                                "<p>光属性</p>" +
                                "<p>" + result.light + "</p>" +
                            "</div>" +
                            "<div class='detailSummon'>" +
                                "<p>闇属性</p>" +
                                "<p>" + result.dark + "</p>" +
                            "</div>" +
                            "<div class='detailSummon'>" +
                                "<p>フリー１</p>" +
                                "<p>" + result.free1 + "</p>" +
                            "</div>" +
                            "<div class='detailSummon'>" +
                                "<p>フリー２</p>" +
                                "<p>" + result.free2 + "</p>" +
                            "</div>" +
                        "</div>" +

                        "<div id='detailGameID'>" +
                            "<p class='cont'>ゲームID</p>" +
                            "<p class='resultGameID'>" + result.GameID + "</p>" +
                        "</div>" +
                    "</div>" +
                        "<div id='detailDate'>" +
                            "<p class='cont'>投稿日時</p>" +
                            "<p>" + result.recrDate + "</p>" +
                        "</div>" +
                        "<form action='process/deleteFriend.php' method='post'>" +
                            "<input type='hidden' name='FRid' value='" + result.id + "'>" +
                            "<input id='deleteRecr' class='deleteBtn' type='submit' value='募集を締め切る'>" +
                        "</form>" +
                    "</div>"
                );

                //画面のどこかをクリックしたらモーダルを閉じる
                $("#modal-bg").click(function () {
                    $("#modal-detail,#modal-bg").fadeOut("slow", function () {
                        //挿入した<div id="modal-bg"></div>を削除
                        $('#modal-bg').remove();
                        $('#modal-detail').remove();
                    });
                });
                //画面の左上からmodal-mainの横幅・高さを引き、その値を2で割ると画面中央の位置が計算できます
                $(window).resize(modalResize);
                function modalResize() {

                    var w = $(window).width();
                    var h = $(window).height();

                    var cw = $("#modal-detail").outerWidth();
                    var ch = $("#modal-detail").outerHeight();

                    //取得した値をcssに追加する
                    $("#modal-detail").css({
                        "left": ((w - cw) / 2) + "px",
                        "top": ((h - ch) / 2) + "px"
                    });
                }
            }).fail(function (XMLHttpRequest, textStatus, errorThrown) {
                // 通常はここでtextStatusやerrorThrownの値を見て処理を切り分けるか、単純に通信に失敗した際の処理を記述します。

                // this;
                // thisは他のコールバック関数同様にAJAX通信時のオプションを示します。

                // エラーメッセージの表示
                alert('Error : ' + errorThrown);
            });
            // サブミット後、ページをリロードしないようにする
            return false;
        });
    });

});

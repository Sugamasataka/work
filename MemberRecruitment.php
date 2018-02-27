<?php

require_once($_SERVER['DOCUMENT_ROOT'].'/shupre/classes/Conf.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/shupre/classes/entity/member.class.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/shupre/classes/dao/MemberRecrDAO.class.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/shupre/classes/dao/templateDAO.class.php');

$validationMsgs=null;

 $email = $_SESSION["email"];
$_SESSION["validationMsgs"] = $validationMsgs;
$recrList = [];
$taglist = [];
try{
    $db = new PDO(DB_DNS,DB_USERNAME,DB_PASSWORD);
    $process = new MemberRecrDAO($db);
    $template = new templateDAO($db);
    $tempID = $template->findTemplateMember($email);
    if(isset($_POST["tag"])) {
        $tag = $_POST["tag"];
        $recrList = $process->FindTag($tag);
    }
    else{
        $recrList = $process->MemberRecrAll();
    }
}
catch (PDOException $ex){
    print_r($ex);
    $_SESSION["errorMsg"]="DB接続に失敗しました。";
}
finally{
    $db = null;
}
if(isset($_SESSION["errorMsg"])){
    header("location: shupre/error.php");
}
if(isset($_SESSION["validationMsgs"])) {
    $validationMsgs=$_SESSION["validationMsgs"];
}
unset($_SESSION["validationMsgs"]);
?>
<!doctype html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/memberRecruitment.css">
    <title>グラブル募集掲示板 | 団員募集</title>
</head>
<body>

<header>
<h1>グラブル募集掲示板</h1>
    <div id="userNav">
        <ul>
            <li><a href="MemberRecruitment.php">団員募集</a></li>
            <li><a href="FriendRecr.php">フレンド募集</a></li>
            <li><a href="">チャット</a></li>
            <li><a href="mypage.php">マイページ</a></li>
            <li><a href="logout.php">ログアウト</a></li>
        </ul>
    </div>
</header>
<div id="contents">
<main>
<h2>団員募集</h2>
        <div id="RecrNav">
            <p  id="modal-open" class="recrButton">団員を募集する</p>
            <p  id="tag-open" class="recrButton">方針で探す</p>
        </div>

        <!-- 投稿リストを表示 -->
        <div id="RecrList">
            <?php
            if(empty($recrList)) {
                ?>
                    <p>投稿がありません</p>
                <?php
            }
            else {
                foreach($recrList as $recr) {
                    ?>
                    <div class="recrCard">

                        <p class="teamName"><?= $recr->getTeamName() ?></p>

                        <div class="commentBox">
                            <p class="commentile">募集内容</p>
                            <p class="comment"><?= $recr->getRecrCont() ?></p>
                        </div>
                        <div class="tagList">
                            <p>団の方針</p>
                            <?
                            $taglist = explode(",",$recr->getTag());
                            foreach ($taglist as $id){
                                $tagName = $process ->TagList($id);
                                if (!empty($tagName)) {
                                    ?>
                                    <form action="MemberRecruitment.php" method="post">
                                        <input type="hidden" name="tag"  value="<?= $id ?>">
                                        <input type="submit" class="tag" value="<?= $tagName ?>">
                                    </form>
                                    <?
                                }
                            }
                            ?>
                        </div>
                        <div class="RecrDate">
                            <p>投稿日時</p>
                            <p><?= $recr->getRecrDate() ?></p>
                        </div>

                        <form method="post">
                            <input type="hidden" id="<?= $recr->getMRid() ?>" class="MRid" name="MRid" value="<?= $recr->getMRid() ?>">
                            <input type="submit" class="detail" value="詳しく見る">
                        </form>
                    </div>
                    <?php
                }
            }
            ?>
            </div>

    <div id="alertCopy">
        <p>コピーしました</p>
    </div>

</main>
</div>
<!----------------------- 入力フォーム ------------------------------>
<div id="form">
    <?php
    if(!empty($tempID)) {
        ?>
        <p id="tempID" class="hide"><?= $tempID->getMRid() ?></p>
        <p id="tempTeamName" class="hide"><?= $tempID->getTeamName() ?></p>
        <p id="tempGameID" class="hide"><?= $tempID->getGameId() ?></p>
        <p id="tempCont" class="hide"><?= $tempID->getRecrCont() ?></p>
        <p id="tempMember" class="hide"><?= $tempID->getNumberMember() ?></p>
        <p id="tempAT1" class="hide"><?= $tempID->getAt1() ?></p>
        <p id="tempAT2" class="hide"><?= $tempID->getAt2() ?></p>
        <p id="tempTag" class="hide"><?= $tempID->getTag() ?></p>
        <p id="callTemp">テンプレートを入力する</p>
        <?php
    }
    ?>
    <h3>募集フォーム</h3>
        <form action="MemberRecrAdd.php" method="post">
            <div class="box">
                <p class="formName">団名</p>
                <input type="text" id="TeamName" name="TeamName">
            </div>

            <div class="box">
                <p class="formName">投稿者ID</p>
                <input type="number" id="GameId" name="GameId" maxlength="9">
            </div>

            <div class="contBox">
                <p class="formName">募集内容</p>
                <textarea name="RecrCont" id="RecrCont" class="RecrCont" cols="30" rows="10" maxlength="1000"></textarea>
            </div>


            <div class="box">
            <p class="formName">現在の団員数</p>
            <select id="member" name="NumberMember">
                <?php
                for($member=1; $member<=30; $member++) {
                    ?>
                    <option value="<?= $member ?>"><?= $member ?></option>
                    <?php
                }
                ?>
            </select>
            </div>

            <div id="assaultTime">
                <div class="at">
                    <p class="formName">アサルトタイム①</p>
                    <select id="AT1" class="atTime" name="AT_1">
                        <?php
                        for($AT=0; $AT<=23; $AT++) {
                            ?>
                            <option value="<?= $AT ?>:00"><?= $AT ?>:00~</option>
                            <?php
                        }
                        ?>
                    </select>
                </div>
                <div class="at">
                    <p class="formName">アサルトタイム②</p>
                    <select id="AT2" class="atTime" name="AT_2">
                        <?php
                        for($AT=0; $AT<=23; $AT++) {
                            ?>
                            <option value="<?= $AT ?>:00"><?= $AT ?>:00~</option>
                            <?php
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="tags">
                <p class="formName">団の方針</p>

                <input type="checkbox" name="tag[]" value="01">新設団
                <input type="checkbox" name="tag[]" value="02">まったり
                <input type="checkbox" name="tag[]" value="03">リアル優先
                <input type="checkbox" name="tag[]" value="04">初心者歓迎
                <input type="checkbox" name="tag[]" value="05">がっつり
                <input type="checkbox" name="tag[]" value="06">Aリーグ進出
                <input type="checkbox" name="tag[]" value="07">Bリーグ進出
                <input type="checkbox" name="tag[]" value="08">Cリーグ進出 <br>
                <input type="checkbox" name="tag[]" value="09">本戦進出
                <input type="checkbox" name="tag[]" value="10">本戦勝利
                <input type="checkbox" name="tag[]" value="11">本戦全勝
                <input type="checkbox" name="tag[]" value="12">外部サービス利用
                <input type="checkbox" name="tag[]" value="13">外部サービス利用しない
            </div>
            <input type="hidden" name="email" value="<?=$_SESSION["email"]?>">

            <input type="submit" id="submit" name="submit" value="募集する">
        </form>
</div>

<script type="text/javascript" src="js/jquery-3.3.1.min.js"></script>
<script type="text/javascript" src="js/dist/clipboard.min.js"></script>
<script type="text/javascript" src="js/MemberRecr.js"></script>
<script>
    $(document).ready(function() {
        /**
         * 送信ボタンクリック
         */
        $('.detail').click(function() {
            // POSTメソッドで送るデータを定義します var data = {パラメータ名 : 値};
            var index = $('.detail').index(this);
            var　MRid = $('.MRid').eq(index).val();
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
                data:{'MRid':MRid},
                dataType: "json",
            }).done(function(result,dataType) {

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
                    "<div id='detailContents'>"+

                    "<div id='detailTeamName'>"+
                    "<p>" + result.TeamName + "</p>"+
                    "</div>"+
                    "<div id='detailContributor'>"+
                    "<p class='cont'>投稿者</p>"+
                    "<p>" + result.Contributor + "</p>"+
                    "</div>"+
                    "<div id='detailLeft'>"+
                    "<div id='detailCont'>"+
                    "<p class='cont'>募集内容</p>"+
                    "<p class='resultCont'>" + result.cont + "</p>"+
                    "</div>" +

                    "</div>" +
                    "<div id='detailRight'>"+
                    "<div id='detailTags'>"+
                    "<p id=''>団の方針</p>" +
                    "<div id='tagBox'>" +
                    "</div>"+
                    "</div>"+
                    "<div id='detailAt'>"+
                    "<p class='cont'>アサルトタイム</p>"+
                    "<p class='resultAt'>" + result.AT1 + "</p>"+
                    "<p class='resultAt'>" + result.AT2 + "</p>"+
                    "</div>"+


                    "<div id='detailGameID'>"+
                    "<p class='cont'>ゲームID</p>"+
                    "<p class='resultGameID'>" + result.GameID + "</p>"+
                    "<p class='copyID' onclick='copyText("+result.GameID+")'>コピーする</p>" +
                    "</div>"+
                    "</div>" +
                    "<div id='detailDate'>"+
                    "<p class='cont'>投稿日時</p>"+
                    "<p>" + result.recrDate + "</p>"+
                    "</div>"+
                    "</div>"
                );

                //方針(タグ)を一つずつ表示
                for (var i =0; i<result.tag.length; i++) {
                    $("#tagBox").append("<p class='detailTag'>" + result.tag[i] + "</p>");

                }
                //画面のどこかをクリックしたらモーダルを閉じる
                $("#modal-bg").click(function(){
                    $("#modal-detail,#modal-bg").fadeOut("slow",function(){
                        //挿入した<div id="modal-bg"></div>を削除
                        $('#modal-bg').remove() ;
                        $('#modal-detail').remove() ;
                    });
                });
                //画面の左上からmodal-mainの横幅・高さを引き、その値を2で割ると画面中央の位置が計算できます
                $(window).resize(modalResize);
                function modalResize(){

                    var w = $(window).width();
                    var h = $(window).height();

                    var cw = $("#modal-detail").outerWidth();
                    var ch = $("#modal-detail").outerHeight();
                    var sh = screen.availHeight;

                    //取得した値をcssに追加する
                    $("#modal-detail").css({
                        "left": ((w - cw)/2) + "px",
                        "top": ((h - ch)/2) + "px"
                    });
                }
            }).fail(function(XMLHttpRequest, textStatus, errorThrown) {
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

</script>

</body>
</html>

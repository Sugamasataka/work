<?php

require_once($_SERVER['DOCUMENT_ROOT'].'/shupre/classes/Conf.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/shupre/classes/entity/member.class.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/shupre/classes/dao/FriendRecrDAO.class.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/shupre/classes/dao/templateDAO.class.php');

$validationMsgs = null;

$email = $_SESSION["email"];
$_SESSION["validationMsgs"] = $validationMsgs;
$template = "";
$tempID = "";
$recrList = [];
try{
    $db = new PDO(DB_DNS,DB_USERNAME,DB_PASSWORD);
    $process = new FriendRecrDAO($db);
    $template = new templateDAO($db);
    $recrList = $process-> FriendRecrALL();
    $tempID = $template->findTemplateFriend($email);
}
catch (PDOException $ex){
    print_r($ex);
    $_SESSION["errorMsg"]="DB接続に失敗しました。";
}
finally{
    $db = null;
}
if(isset($_SESSION["errorMsg"])){
    header("location: error.php");
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
    <link rel="stylesheet" href="css/FriendRecr.css">
    <title>Document</title>
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
        <h2>フレンド募集</h2>
    <div id="RecrNav">
        <p  id="modal-open" class="recrButton">フレンドを募集する</p>
        <p  id="tag-open" class="recrButton">召喚石で探す</p>
    </div>
<?php
if(!is_null($validationMsgs)) {
    ?>
    <section id="errorMsg">
        <p>以下のメッセージをご確認ください。</p>
        <ul>
            <?php
            foreach($validationMsgs as $msg) {
                ?>
                <li><?php print($msg) ?></li>
                <?php
            }
            ?>
        </ul>
    </section>
    <?php
}
?>

    <div id="form">
        <?php
        if(!empty($tempID)) {
            ?>
            <p id="tempID" class="hide"><?= $tempID->getFRid() ?></p>
            <p id="tempTitle" class="hide"><?= $tempID->getFRecrTitle() ?></p>
            <p id="tempGameID" class="hide"><?= $tempID->getGameId() ?></p>
            <p id="tempCont" class="hide"><?= $tempID->getFRecrCont() ?></p>
            <p id="tempFire" class="hide"><?= $tempID->getFire() ?></p>
            <p id="tempWater" class="hide"><?= $tempID->getWater() ?></p>
            <p id="tempEarth" class="hide"><?= $tempID->getEarth() ?></p>
            <p id="tempWind" class="hide"><?= $tempID->getWind() ?></p>
            <p id="tempLight" class="hide"><?= $tempID->getLight() ?></p>
            <p id="tempDark" class="hide"><?= $tempID->getDark() ?></p>
            <p id="tempFree1" class="hide"><?= $tempID->getFree1() ?></p>
            <p id="tempFree2" class="hide"><?= $tempID->getFree2() ?></p>
            <p id="callTemp">テンプレートを入力する</p>
            <?php
        }
        ?>
        <h3>投稿フォーム</h3>
        <form action="FriendRecrAdd.php" method="post">
            <div class="box">
                <p class="formName">募集タイトル</p>
                <input type="text" id="FRecrTitle" name="FRecrTitle" placeholder="20文字以内" maxlength="20">
            </div>

            <div class="box">
                <p class="formName">投稿者ID</p>
                <input type="text" id="GameId" name="GameId" pattern="\d*" maxlength="9" placeholder="数字で入力">
            </div>

            <div class="contBox">
                <p class="formName">募集内容</p>
                <textarea name="FRecrCont" id="FRecrCont" class="FRecrCont" cols="30" rows="10" maxlength="1000"></textarea>
            </div>
            <div class="summonSelectBox">
                <div class="summonSelect">
                    <p>火属性サポート召喚石</p>
                    <select class="summon" id="Fire" name="Fire">
                        <option value="未設定">未設定</option>
                        <option value="アグニス">アグニス</option>
                        <option value="アテナ">アテナ</option>
                        <option value="イフリート">イフリート</option>
                        <option value="コロッサス・マグナ">コロッサス・マグナ</option>
                        <option value="シヴァ">シヴァ</option>
                        <option value="センランス">センランス</option>
                    </select>
                    <select name="FireState" id="FireState" class="state">
                        <option value="無解放">無解放</option>
                        <option value="3凸">3凸</option>
                        <option value="4凸">4凸</option>
                    </select>
                </div>
                <div class="summonSelect">
                <p>水属性サポート召喚石</p>
                <select id="Water" class="summon" name="Water">
                    <option value="未設定">未設定</option>
                    <option value="ヴァルナ">ヴァルナ</option>
                    <option value="エウロペ">エウロペ</option>
                    <option value="無解放">カツウォヌス</option>
                    <option value="コキュートス">コキュートス</option>
                    <option value="リヴァイアサン・マグナ">リヴァイアサン・マグナ</option>
                </select>
                <select name="WaterState" id="WaterState" class="state">
                    <option value="無解放">無解放</option>
                    <option value="3凸">3凸</option>
                    <option value="4凸">4凸</option>
                </select>
                </div>
                <div class="summonSelect">
                <p>土属性サポート召喚石</p>
                <select id="Earth" class="summon" name="Earth">
                    <option value="未設定">未設定</option>
                    <option value="ウォフマナフ">ウォフナマフ</option>
                    <option value="ティターン">ティターン</option>
                    <option value="テスカリポカ">テスカリポカ</option>
                    <option value="バアル">バアル</option>
                    <option value="メデューサ">メデューサ</option>
                    <option value="ユグドラシル・マグナ">ユグドラシル・マグナ</option>
                </select>
                <select name="EarthState" id="EarthState" class="state">
                    <option value="無解放">無解放</option>
                    <option value="3凸">3凸</option>
                    <option value="4凸">4凸</option>
                </select>
                </div>
                <div class="summonSelect">
                <p>風属性サポート召喚石</p>
                <select id="Wind" class="summon" name="Wind">
                    <option value="未設定">未設定</option>
                    <option value="アナト">アナト</option>
                    <option value="グリームニル">グリームニル</option>
                    <option value="サジタリウス">サジタリウス</option>
                    <option value="ゼピュロス">ゼピュロス</option>
                    <option value="ティアマト・マグナ">ティアマト・マグナ</option>
                    <option value="ナタク">ナタク</option>
                </select>
                <select name="WindState" id="WindState" class="state">
                    <option value="無解放">無解放</option>
                    <option value="3凸">3凸</option>
                    <option value="4凸">4凸</option>
                </select>
                </div>
                <div class="summonSelect">
                <p>光属性サポート召喚石</p>
                <select id="Light" class="summon" name="Light">
                    <option value="未設定">未設定</option>
                    <option value="アポロン">アポロン</option>
                    <option value="オーディン">オーディン</option>
                    <option value="コロゥ">コロゥ</option>
                    <option value="シュヴァリエ・マグナ">シュヴァリエ・マグナ</option>
                    <option value="ゼウス">ゼウス</option>
                    <option value="ルシフェル">ルシフェル</option>
                </select>
                <select name="LightState" id="LightState" class="state">
                    <option value="無解放">無解放</option>
                    <option value="3凸">3凸</option>
                    <option value="4凸">4凸</option>
                </select>
                </div>
                <div class="summonSelect">
                <p>闇属性サポート召喚石</p>
                <select id="Dark" class="summon" name="Dark">
                    <option value="未設定">未設定</option>
                    <option value="セレスト・マグナ">セレスト・マグナ</option>
                    <option value="ディアボロス">ディアボロス</option>
                    <option value="Dエンジェル・オリヴィエ">Dエンジェル・オリヴィエ</option>
                    <option value="ハデス">ハデス</option>
                    <option value="バハムート">バハムート</option>
                </select>
                <select name="DarkState" id="DarkState" class="state">
                    <option value="無解放">無解放</option>
                    <option value="3凸">3凸</option>
                    <option value="4凸">4凸</option>
                </select>
                </div>
                <div class="summonSelect">
                <p>フリーサポート召喚石1</p>
                <select id="Free1" class="summon" name="Free1">
                    <option value="未設定">未設定</option>
                    <option value="カグヤ">カグヤ</option>
                    <option value="ケット・シー">ケット・シー</option>
                    <option value="ジ・オーダー・グランデ">ジ・オーダー・グランデ</option>
                    <option value="トール">トール</option>
                    <option value="ホワイト・ラビット">ホワイト・ラビット</option>
                </select>
                <select name="Free1State" id="Free1State" class="state">
                    <option value="無解放">無解放</option>
                    <option value="3凸">3凸</option>
                    <option value="4凸">4凸</option>
                </select>
                </div>
                <div class="summonSelect">
                <p>フリーサポート召喚石2</p>
                <select id="Free2" class="summon" name="Free2">
                    <option value="未設定">未設定</option>
                    <option value="カグヤ">カグヤ</option>
                    <option value="ケット・シー">ケット・シー</option>
                    <option value="ジ・オーダー・グランデ">ジ・オーダー・グランデ</option>
                    <option value="トール">トール</option>
                    <option value="ホワイト・ラビット">ホワイト・ラビット</option>
                </select>
                <select name="Free2State" id="Free2State" class="state">
                    <option value="無解放">無解放</option>
                    <option value="3凸">3凸</option>
                    <option value="4凸">4凸</option>
                </select>
                </div>
            </div>
            <input type="hidden" name="email" value="<?=$_SESSION["email"] ?>">
            <input type="submit" id="submit" name="submit" value="募集する">
        </form>
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

                        <p class="teamName"><?= $recr->getFRecrTitle()?></p>

                        <div class="commentBox">
                            <p class="commentile">募集内容</p>
                            <p class="comment"><?= $recr->getFRecrCont() ?></p>
                        </div>

                        <div class="summonBox">
                            <p class="summonTitle">サポート専用召喚石</p>
                                <table class="summonList">
                                    <tr>
                                        <th class="fire">火属性</th>
                                        <th class="water">水属性</th>
                                        <th class="earth">土属性</th>
                                    </tr>
                                    <tr>
                                        <td class="fire"><?= $recr->getFire() ?></td>
                                        <td class="water"><?= $recr->getWater() ?></td>
                                        <td class="earth"><?= $recr->getEarth() ?></td>
                                    </tr>
                                    <tr>
                                        <th class="wind">風属性</th>
                                        <th class="light">光属性</th>
                                        <th class="dark">闇属性</th>
                                    </tr>
                                    <tr>
                                        <td class="wind"><?= $recr->getWind() ?></td>
                                        <td class="light"><?= $recr->getLight() ?></td>
                                        <td class="dark"><?= $recr->getDark() ?></td>
                                    </tr>
                                    <tr>
                                        <th class="free">フリー1</th>
                                        <th class="free">フリー2</th>

                                    </tr>
                                    <tr>
                                        <td class="free"><?= $recr->getFree1() ?></td>
                                        <td class="free"><?= $recr->getFree2() ?></td>
                                    </tr>
                                </table>
                        </div>
                        <div class="RecrDate">
                            <p>投稿日時</p>
                            <p><?= $recr->getFRecrDate() ?></p>
                        </div>

                        <form method="post">
                            <input type="hidden" id="<?= $recr->getFRid() ?>" class="FRid" name="FRid" value="<?= $recr->getFRid() ?>">
                            <input type="submit" class="detail" value="詳しく見る">
                        </form>
                    </div>
                    <?php
                }
            }
            ?>
        </div>
    </main>
    </div>

    <div id="alertCopy">
        <p>コピーしました</p>
    </div>

<script type="text/javascript" src="js/jquery-3.3.1.min.js"></script>
<script type="text/javascript" src="js/dist/clipboard.min.js"></script>
<script type="text/javascript" src="js/FriendRecr.js"></script>
<script>
    $(document).ready(function() {
        /**
         * 送信ボタンクリック
         */
        $('.detail').click(function() {
            // POSTメソッドで送るデータを定義します var data = {パラメータ名 : 値};
            var index = $('.detail').index(this);
            var　FRid = $('.FRid').eq(index).val();
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
                data:{'FRid':FRid},
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
                    "<p>" + result.Title + "</p>"+
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
                    "<div id='detailRight'>" +
                        "<div id='detailSummonBox'>" +
                        "<p>サポーター専用召喚石一覧</p>" +
                            "<div class='detailSummon'>" +
                                "<p>火属性</p>" +
                                "<p>"+ result.flame +"</p>" +
                            "</div>" +
                            "<div class='detailSummon'>" +
                                "<p>水属性</p>" +
                                "<p>"+ result.water+"</p>" +
                            "</div>" +
                            "<div class='detailSummon'>" +
                                "<p>土属性</p>" +
                                "<p>"+result.earth+"</p>" +
                            "</div>" +
                            "<div class='detailSummon'>" +
                                "<p>風属性</p>" +
                                "<p>"+result.wind+"</p>" +
                            "</div>" +
                            "<div class='detailSummon'>" +
                                "<p>光属性</p>" +
                                "<p>"+result.light+"</p>" +
                            "</div>" +
                            "<div class='detailSummon'>" +
                                "<p>闇属性</p>" +
                                "<p>"+result.dark+"</p>" +
                            "</div>"+
                            "<div class='detailSummon'>" +
                                "<p>フリー１</p>" +
                                "<p>"+result.free1+"</p>" +
                            "</div>"+
                            "<div class='detailSummon'>" +
                                "<p>フリー２</p>" +
                                "<p>"+result.free2+"</p>" +
                            "</div>" +
                        "</div>"+

                        "<div id='detailGameID'>"+
                        "<p class='cont'>ゲームID</p>"+
                        "<p class='resultGameID'>" + result.GameID + "</p>"+
                        "<p class='copyID' onclick='copyText("+result.GameID+")'>コピーする</p>" +
                        "</div>" +
                    "</div>"+
                    "</div>" +
                    "<div id='detailDate'>"+
                    "<p class='cont'>投稿日時</p>"+
                    "<p>" + result.recrDate + "</p>"+
                    "</div>"+
                    "</div>"
                );

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

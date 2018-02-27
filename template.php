<?php

require_once($_SERVER['DOCUMENT_ROOT'].'/shupre/classes/Conf.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/shupre/classes/entity/member.class.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/shupre/classes/dao/templateDAO.class.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/shupre/classes/dao/memberDAO.class.php');



$friendTemplateList = [];
$memberTemplateList = [];

$friendTemplate ="";
$memberTemplate ="";

if(isset($_SESSION["email"])) {
    $email = $_SESSION["email"];

    try {
        $db = new PDO(DB_DNS,DB_USERNAME,DB_PASSWORD);
        $friendTemplate = new templateDAO($db);
        $memberTemplate = new templateDAO($db);
        $memberTemplateList = $memberTemplate->findTemplateMember($email);
        $friendTemplateList = $friendTemplate->findTemplateFriend($email);


    } catch (PDOException $ex) {
        print_r($ex);
        $_SESSION["errorMsg"] = "予期せぬエラーが発生しました。";
    } finally {
        $db = null;
    }
}
else{
    header("location: index.html");
}

if(isset($_SESSION["errorMsg"])){
    header("location: /error.php");
}
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
    <link rel="stylesheet" href="css/mypage.css">
    <link rel="stylesheet" href="css/template.css">
    <link rel="stylesheet" href="css/modal.css">
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
    <div id="contentsLeft">

        <div id="leftNav">
            <ul>
                <li class="navBtn "><a href="mypage.php">プロフィール</a></li>
                <li class="navBtn "><a href="recrHistory.php">投稿履歴</a></li>
                <li class="navBtn "><a href="template.php">投稿のテンプレート作成</a></li>
            </ul>
        </div>

    </div>

    <div id="contentsRight">
       <div id="Box">
           <ul class="tab">
               <li class="select">団員募集</li>
               <li class=>フレンド募集</li>
           </ul>
           <div id="templateBox">

               <div id="memberTemplate" class="template">
                   <?php
                   if(empty($memberTemplateList)) {
                       ?>
                       <div id="Msg">
                           <h3>テンプレート(団員募集)</h3>
                           <p>登録しているテンプレートはありません</p>
                           <p>テンプレートを登録することでスムーズに投稿することができます!</p>
                           <p id="registerMember" class="btn">登録する</p>
                       </div>
                       <?php
                   }
                   else {

                           ?>
                           <div class="recrCard">

                               <div class="box">
                                   <p class="boxTitle">団名</p>
                                   <p id="tempTitleR" class="boxCont"><?= $memberTemplateList->getTeamName() ?></p>
                               </div>

                               <div class="box">
                                   <p class="boxTitle">投稿者ID</p>
                                   <p id="tempIDM" class="boxCont"><?= $memberTemplateList->getGameId()?></p>
                               </div>

                               <div class="contBox">
                                   <p class="boxTitle">募集内容</p>
                                   <p id="tempContM" class="RecrCont"><?= $memberTemplateList->getRecrCont() ?></p>
                               </div>

                               <div class="box">
                                   <p class="boxTitle">現在の団員数</p>
                                   <p id="tempMember" class="boxCont"><?= $memberTemplateList->getNumberMember()?></p>
                               </div>
                               <div class="box">
                                   <p class="boxTitle">アサルトタイム</p>
                                   <p id="tempAssault1" class="at"><?= $memberTemplateList->getAt1()?></p>
                                   <p id="tempAssault2" class="at"><?= $memberTemplateList->getAt2()?></p>
                               </div>

                               <div class="tagList">
                                   <p>団の方針</p>
                                   <?
                                   $taglist = explode(",",$memberTemplateList->getTag());
                                   foreach ($taglist as $id){
                                       $tagName = $memberTemplate ->TagList($id);
                                       if (!empty($tagName)) {
                                           ?><p class="tagName"><?= $id ?></p>
                                           <p class="tags"><?= $tagName ?></p>
                                           <?
                                       }
                                   }
                                   ?>
                               </div>

                               <div class="RecrDate">
                                   <p>投稿日時</p>
                                   <p><?= $memberTemplateList->getRecrDate() ?></p>
                               </div>

                               <div class="btnBox">
                                   <p id="editBtnMember">編集</p>
                                   <p class="email"><?= $memberTemplateList->getEmail() ?></p>
                               </div>
                           </div>
                           <?php
                   }
                   ?>
               </div>

               <div id="friendTemplate" class="template hide">
                   <?php
                   if(empty($friendTemplateList)) {
                       ?>
                       <div id="Msg">
                           <h3>テンプレート(フレンド)</h3>
                           <p>登録しているテンプレートはありません</p>
                           <p>テンプレートを登録することでスムーズに投稿することができます!</p>
                           <p id="registerFriend" class="btn">登録する</p>
                       </div>
                       <?php
                   }
                   else {
                   ?>

                           <div class="box">
                               <p class="boxTitle">募集タイトル</p>
                               <p id="tempTitleF" class="boxCont"><?= $friendTemplateList->getFRecrTitle()?></p>
                           </div>
                           <div class="box">
                               <p class="boxTitle">投稿者ID</p>
                               <p id="tempIDF" class="boxCont"><?= $friendTemplateList->getGameId()?></p>
                           </div>
                           <div class="contBox">
                               <p class="boxTitle">募集内容</p>
                               <p id="tempContF" class="RecrCont"><?= $friendTemplateList->getFRecrCont()?></p>
                           </div>
                           <div id="supportList">
                               <p class="supportTitle">サポート召喚石一覧</p>
                                   <dl>
                                       <dt>火属性サポート召喚石</dt>
                                       <dd id="fire"><?= $friendTemplateList->getFire()?></dd>
                                   </dl>
                                   <dl>
                                       <dt>水属性サポート召喚石</dt>
                                       <dd id="water"><?= $friendTemplateList->getWater()?></dd>
                                   </dl>

                                   <dl>
                                       <dt>土属性サポート召喚石</dt>
                                       <dd id="earth"><?= $friendTemplateList->getEarth()?></dd>
                                   </dl>
                                   <dl>
                                       <dt>風属性サポート召喚石</dt>
                                       <dd id="wind"><?= $friendTemplateList->getWind()?></dd>
                                   </dl>
                                   <dl>
                                       <dt>光属性サポート召喚石</dt>
                                       <dd id="light"><?= $friendTemplateList->getLight()?></dd>
                                   </dl>

                                   <dl>
                                       <dt>闇属性サポート召喚石</dt>
                                       <dd id="dark"><?= $friendTemplateList->getDark()?></dd>
                                   </dl>

                                   <dl>
                                       <dt>フリーサポート召喚石1</dt>
                                       <dd id="free1"><?= $friendTemplateList->getFree1()?></dd>
                                   </dl>
                                   <dl>
                                       <dt>フリーサポート召喚石2</dt>
                                       <dd id="free2"><?= $friendTemplateList->getFree2()?></dd>
                                   </dl>
                           </div>
                           <div class="RecrDate">
                               <p>登録日</p>
                               <p><?= $friendTemplateList->getFRecrDate() ?></p>
                           </div>
                           <div class="btnBox">
                               <p id="editBtnFriend">編集</p>
                               <p class="email"><?= $friendTemplateList->getEmail() ?></p>
                           </div>

                   <?php
               }
               ?>
               </div>

               <div id="MemberForm" class="template">
                   <h3>募集フォーム(団員)</h3>
                   <form name="form1" action="process/memberTemplate.php" method="post">
                       <div class="box">
                           <p class="formName">団名</p>
                           <input type="text" id="TeamName" name="TeamName">
                       </div>

                       <div class="box">
                           <p class="formName">投稿者ID</p>
                           <input type="number" id="GameIdM" name="GameId" maxlength="9">
                       </div>

                       <div class="contBox">
                           <p class="formName">募集内容</p>
                           <textarea id="RecrCont" name="RecrCont" class="RecrCont" cols="30" rows="10" maxlength="1000"></textarea>
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
                       <div class="tagList">
                           <p class="formName">団の方針</p>

                           <input type="checkbox" class="tags" name="tag[]" value="01">新設団
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

                       <p id="cancelMT">キャンセル</p>
                       <input type="submit" id="submit" name="submit" value="登録">
                   </form>
               </div>

               <div id="friendForm" class="template">

                   <h3>テンプレート登録(フレンド)</h3>
                   <form action="process/friendTemplate.php" method="post">
                       <div class="box">
                           <p class="formName">募集タイトル</p>
                           <input type="text" id="FRecrTitle" name="FRecrTitle" placeholder="20文字以内" maxlength="20">
                       </div>

                       <div class="box">
                           <p class="formName">投稿者ID</p>
                           <input type="text" id="GameIdF" name="GameId" pattern="\d*" maxlength="9" placeholder="数字で入力">
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
                                   <option value="カツウォヌス">カツウォヌス</option>
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
                       <input type="hidden" id="FRecremail" name="email" value="<?=$_SESSION["email"] ?>">
                       <p id="cancelFT">キャンセル</p>
                       <input type="submit" id="submit" name="submit" value="登録">
                   </form>
               </div>
           </div>
       </div>

       </div>
    </div>
<script type="text/javascript" src="js/jquery-3.3.1.min.js"></script>
<script type="text/javascript" src="js/template.js"></script>


</body>
</html>


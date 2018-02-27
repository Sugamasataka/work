<?php

require_once($_SERVER['DOCUMENT_ROOT'].'/shupre/classes/Conf.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/shupre/classes/entity/member.class.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/shupre/classes/dao/MemberDAO.class.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/shupre/classes/dao/FriendRecrDAO.class.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/shupre/classes/dao/MemberRecrDAO.class.php');

$friendHistoryList = [];
$memberHistoryList = [];
$memberHistory = "";

if(isset($_SESSION["email"])) {
    $email = $_SESSION["email"];

    try {
        $db = new PDO(DB_DNS,DB_USERNAME,DB_PASSWORD);
        $process = new FriendRecrDAO($db);
        $memberHistory = new MemberRecrDAO($db);
        $friendHistoryList = $process->recrFriendHistory($email);
        $memberHistoryList = $memberHistory->recrMemberHistory($email);
        if(isset($_POST["tag"])) {
        $tag = $_POST["tag"];
        $recrList = $memberHistory->FindTag($tag);
    }

    } catch (PDOException $ex) {
        print_r($ex);
        $_SESSION["errorMsg"] = "予期せぬエラーが発生しました。";
    } finally {
        $db = null;
    }
}
else{
    header("location: index.php");
}

if(isset($_SESSION["errorMsg"])){
    header("location: error.php");
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
    <link rel="stylesheet" href="css/recrHistory.css">
    <link rel="stylesheet" href="css/modal.css">
    <title>グラブル募集掲示板 | 募集履歴</title>
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
        <div id="recrBox">

            <ul class="tab">
                <li class="select">団員募集</li>
                <li class="">フレンド募集</li>
            </ul>
            <div class="cardList">
                <?php
                if(empty($memberHistoryList)) {
                    ?>
                    <p>投稿がありません</p>
                    <?php
                }
                else {
                    foreach($memberHistoryList as $recr) {
                        ?>
                        <div class="recrCard">

                            <p class="teamName"><?= $recr->getTeamName() ?></p>

                            <div class="commentBoxMember">
                                <p class="commentTitle">募集内容</p>
                                <p class="comment"><?= $recr->getRecrCont() ?></p>
                            </div>
                            <div class="tagList">
                                <p class="tagTitle">団の方針</p>
                                <?
                                $taglist = explode(",",$recr->getTag());
                                foreach ($taglist as $id){
                                    $tagName = $memberHistory ->TagList($id);
                                    if (!empty($tagName)) {
                                        ?>
                                        <p class="tagName"><?= $tagName?></p>
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
                                <input type="submit" class="detailMember" value="詳しく見る">
                            </form>
                        </div>
                        <?php
                    }
                }
                ?>
            </div>
            <div class="cardList hide">
                <?php
                if(empty($friendHistoryList)) {
                    ?>
                    <p>投稿がありません</p>
                    <?php
                }
                else {
                foreach($friendHistoryList as $FHistory) {
                ?>
                    <div class="recrCard">

                        <p class="teamName"><?= $FHistory->getFRecrTitle()?></p>

                        <div class="commentBox">
                            <p class="commentTitle">募集内容</p>
                            <p class="comment"><?= $FHistory->getFRecrCont() ?></p>
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
                                    <td class="fire"><?= $FHistory->getFire() ?></td>
                                    <td class="water"><?= $FHistory->getWater() ?></td>
                                    <td class="earth"><?= $FHistory->getEarth() ?></td>
                                </tr>
                                <tr>
                                    <th class="wind">風属性</th>
                                    <th class="light">光属性</th>
                                    <th class="dark">闇属性</th>
                                </tr>
                                <tr>
                                    <td class="wind"><?= $FHistory->getWind() ?></td>
                                    <td class="light"><?= $FHistory->getLight() ?></td>
                                    <td class="dark"><?= $FHistory->getDark() ?></td>
                                </tr>
                                <tr>
                                    <th class="free">フリー1</th>
                                    <th class="free">フリー2</th>

                                </tr>
                                <tr>
                                    <td class="free"><?= $FHistory->getFree1() ?></td>
                                    <td class="free"><?= $FHistory->getFree2() ?></td>
                                </tr>
                            </table>
                        </div>

                        <div class="RecrDate">
                            <p>投稿日時</p>
                            <p><?= $FHistory->getFRecrDate() ?></p>
                        </div>

                        <form method="post">
                            <input type="hidden" id="<?= $FHistory->getFRid() ?>" class="FRid" name="FRid" value="<?= $FHistory->getFRid() ?>">
                            <input type="submit" class="detailFriend" value="詳しく見る">
                        </form>
                    </div>
                    <?php
                    }
                }
                ?>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="js/jquery-3.3.1.min.js"></script>
<script type="text/javascript" src="js/recrHistory.js"></script>


</body>
</html>


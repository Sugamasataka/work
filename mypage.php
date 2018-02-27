<?php

require_once($_SERVER['DOCUMENT_ROOT'].'/shupre/classes/Conf.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/shupre/classes/entity/member.class.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/shupre/classes/dao/MemberDAO.class.php');

$memberRecrList = [];

    if(isset($_SESSION["email"])) {
        $email = $_SESSION["email"];

        try {
            $db = new PDO(DB_DNS,DB_USERNAME,DB_PASSWORD);
            $process = new MemberDAO($db);
            $memberRecrList = $process->mypage($email);

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
    <link rel="stylesheet" href="css/profile.css">
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
        <div id="bigBox">
        <h2>プロフィール</h2>
            <div id="profileBox">
                <div id="profile">
                    <div id="profIcon">
                        <img class="iconImage" src="<?= $memberRecrList->getIcon() ?>" alt="">
                    </div>
                    <div class="profName">
                        <p class="profTitle">アカウント名</p>
                        <p class="name"><?= $memberRecrList->getMemberName() ?></p>
                    </div>
                    <div class="profProfile">
                        <p class="profTitle">自己紹介</p>
                        <p class="profile"><?= $memberRecrList->getprofile() ?></p>
                    </div>
                        <p id="editBtn">編集</p>
                    <p class="id"><?= $memberRecrList->getMemberID() ?></p>
                </div>

            </div>
        </div>
    </div>
</div>
<div id="selectIcon">
<h3>アイコンを選択</h3>
    <div id="selectBox">
        <div class="icon">
            <img class="image"  src="images/character/gran.png" alt="">
        </div>
        <div class="icon">
            <img class="image" src="images/character/djeeta.png" alt="">
        </div>
        <div class="icon">
            <img class="image" src="images/character/Vyrn.png" alt="">
        </div>
        <div class="icon">
            <img class="image" src="images/character/katalina.png" alt="">
        </div>
        <div class="icon">
            <img class="image" src="images/character/rackam.png" alt="">
        </div>
        <div class="icon">
            <img class="image" src="images/character/io.png" alt="">
        </div>
        <div class="icon">
            <img class="image" src="images/character/eugen.png" alt="">
        </div>
        <div class="icon">
            <img class="image" src="images/character/rosetta.png" alt="">
        </div>
        <div class="icon">
            <img class="image" src="images/character/orchid.png" alt="">
        </div>
        <div class="icon">
            <img class="image" src="images/character/black_knight.png" alt="">
        </div>
        <div class="icon">
            <img class="image" src="images/character/sturm.png" alt="">
        </div>
        <div class="icon">
            <img class="image" src="images/character/drang.png" alt="">
        </div>
        <div class="icon">
            <img class="image" src="images/character/zeta.png" alt="">
        </div>
        <div class="icon">
            <img class="image" src="images/character/vaseraga.png" alt="">
        </div>
        <div class="icon">
            <img class="image" src="images/character/beatrix.png" alt="">
        </div>
        <div class="icon">
            <img class="image" src="images/character/eustace.png" alt="">
        </div>
        <div class="icon">
            <img class="image" src="images/character/ladiva.png" alt="">
        </div>
        <div class="icon">
            <img class="image" src="images/character/Lancelot.png" alt="">
        </div>
        <div class="icon">
            <img class="image" src="images/character/vane.png" alt="">
        </div>
        <div class="icon">
            <img class="image" src="images/character/parcval.png" alt="">
        </div>
        <div class="icon">
            <img class="image" src="images/character/lowain.png" alt="">
        </div>
        <div class="icon">
            <img class="image" src="images/character/vira.png" alt="">
        </div>
        <div class="icon">
            <img class="image" src="images/character/zeta.png" alt="">
        </div>


    </div>
    <div id="BtnBox">
        <p id="cancelIcon">キャンセル</p>
        <p id="Decide">適用</p>
    </div>
<script type="text/javascript" src="js/jquery-3.3.1.min.js"></script>
<script type="text/javascript" src="js/mypage.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('#formData').click(function() {
            $('#editForm').submit();
        });
    });
</script>
</body>
</html>


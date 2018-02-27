<?php
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
    <link rel="stylesheet" href="css/index.css">
    <title>グラブル募集掲示板</title>
</head>
<body>
<h1>グラブル募集掲示板</h1>

<main>
    <div class="form">
        <ul class="tab">
            <li class="select">ログイン</li>
            <li class="">新規登録</li>
        </ul>
        <div id="signBox">
            <div class="sign">
                <form action="login.php" method="POST">
                    <p>email</p>
                    <input type="text" name="email" id="logMail" value="">
                    <p>パスワード</p>
                    <input type="password" name="pass" id="pass">
                    <input type="submit" id="loginSubmit" name="submit" value="ログイン">
                </form>
            </div>
            <div class="sign hide">
                    <form action="process/signUp.php" method="POST">
                        <p>アカウント名</p>
                        <input type="text" name="user" id="user" value="">
                        <p>メールアドレス</p>
                        <input type="text" name="email" id="addEmail" value="">
                        <p>パスワード</p>
                        <input type="password" name="pass" id="addPass">
                        <input type="submit" id="addSubmit" name="submit" value="登録">
                    </form>
            </div>
        </div>
    </div>
</main>
<script type="text/javascript" src="js/jquery-3.3.1.min.js"></script>
<script type="text/javascript" src="js/index.js"></script>
</body>
</html>

<?php

$errorMsg = "もう一度始めから操作をお願いします。";
if (isset($_SESSION["errorMsg"])) {
    $errorMsg = $_SESSION["errorMsg"];
}

session_unset();
?>

<!doctype html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="author" content="Shinzo SAITO">
    <title>Error | JavaWebScottadmin Sample</title>
</head>
<body>
<h1>Error</h1>
<section>
    <h2>申し訳ございません。障害が発生しました。</h2>
    <p>
        以下のメッセージご確認ください。<br>
        <?= $errorMsg ?>
    </p>
</section>
<p><a href="/shupre/mypage.php">TOPへ戻る</a></p>
</body>
</html>

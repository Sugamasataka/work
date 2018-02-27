<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/shupre/classes/Conf.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/shupre/classes/entity/member.class.php');

$login=new Member();
if(isset($_SESSION["login"])) {
    $login=$_SESSION["login"];
    $login=unserialize($login);
}

$validationMsgs=null;
if(isset($_SESSION["validationMsgs"])) {
    $validationMsgs=$_SESSION["validationMsgs"];
}

if(isset($_POST["submit"])){

    $email = $_POST["email"];
    $pass = $_POST["pass"];

    $email = trim($email);
    $pass = trim($pass);

    $validationMsgs = [];
    if(strlen($email) == 0){
        $validationMsgs[] = "メールアドレスを入力してください。";
    }
    if(strlen($pass) == 0){
        $validationMsgs[] = "パスワードを入力してください。";
    }

    $login = new Member();
    $login->setEmail($email);

    try{
        $db=new PDO(DB_DNS,DB_USERNAME,DB_PASSWORD);
        $db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

        if(empty($validationMsgs)){

            $sql = "select COUNT(*),password from member where email=:email";
            $stmt = $db->prepare($sql);
            $stmt->bindValue(":email",$login->getEmail(),PDO::PARAM_STR);
            $result = $stmt->execute();

            if(!$result){
                $_SESSION["errorMsg"] = "情報登録に失敗しました。もう一度はじめからやり直してください。";
            }
            $count=1;
            if ($result&&$row = $stmt->fetch(PDO::FETCH_ASSOC)){
                $count = $row["COUNT(*)"];
                $dbPass = $row["password"];
                if($count==1 and $dbPass == $pass) {
                    $_SESSION["email"] = $email;
                    header("location: /shupre/mypage.php");
                    exit;
                }
                else {
                    $validationMsgs[] = "メールアドレスまたはパスワードが違います";
                }
            }
        }
        $_SESSION["login"] = serialize($login);
        $_SESSION["validationMsgs"] = $validationMsgs;
    }
    catch(PDOException $ex) {
        print_r($ex);
        $_SESSION["errorMsg"] = "DB接続に失敗しました。";
    }
    finally {
        $db = null;
    }
    if(isset($_SESSION["errorMsg"])){
        header("Location: /shupre/error.php");
        exit;
    }
    if(!empty($validationMsgs)){
        header("location: /shupre/index.php");
        exit;
    }
}
session_unset();
?>

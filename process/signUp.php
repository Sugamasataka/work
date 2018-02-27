<?php

require_once($_SERVER['DOCUMENT_ROOT'].'/shupre/classes/Conf.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/shupre/classes/entity/member.class.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/shupre/classes/dao/MemberDAO.class.php');

$validationMsgs=null;
if(isset($_POST["submit"])) {

    $user = $_POST["user"];
    $email = $_POST["email"];
    $pass = $_POST["pass"];


    $user = trim($user);
    $email = trim($email);
    $pass = trim($pass);



    $member = new Member();
    $member->setMemberName($user);
    $member->setEmail($email);
    $member->setPass($pass);

    try {
        $db = new PDO(DB_DNS, DB_USERNAME, DB_PASSWORD);
        $process = new MemberDAO($db);
        $result = $process->signUp($member);

        $_SESSION["email"] = $email;
    } catch (PDOException $ex) {
        print_r($ex);
        $_SESSION["errorMsg"] = "DB接続に失敗しました。";
    } finally {
        $db = null;
    }
    header("location: /shupre/mypage.php");
}
else{
    header("location: /shupre/index.php");
}


?>
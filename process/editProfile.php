<?php

require_once($_SERVER['DOCUMENT_ROOT'].'/shupre/classes/Conf.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/shupre/classes/entity/member.class.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/shupre/classes/dao/MemberDAO.class.php');

$validationMsgs=null;



    $id = $_POST["editID"];
    $icon = $_POST["editIcon"];
    $name = $_POST["editName"];
    $profile = $_POST["editProf"];

    $id = trim($id);
    $icon = trim($icon);
    $name = trim($name);
    $profile = trim($profile);

    if(strlen($name) == 0){
        $validationMsgs[] = "名前を入力してください。";
    }

    $member = new Member();
    $member->setMemberID($id);
    $member->setIcon($icon);
    $member->setMemberName($name);
    $member->setProfile($profile);

    $profile = htmlentities($profile, ENT_QUOTES, 'UTF-8');

    try{
        $db = new PDO(DB_DNS,DB_USERNAME,DB_PASSWORD);
        $process = new MemberDAO($db);
        $result = $process->editProfile($member);
    }
    catch (PDOException $ex){
        print_r($ex);
        $_SESSION["errorMsg"]="DB接続に失敗しました。";
    }
    finally{
        $db = null;
    }

    header("location: /shupre/mypage.php");


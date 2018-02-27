<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/shupre/classes/Conf.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/shupre/classes/entity/member.class.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/shupre/classes/dao/MemberRecrDAO.class.php');
$validationMsgs=null;
if(isset($_POST["submit"])){

    $TeamName = $_POST["TeamName"];
    $GameId = $_POST["GameId"];
    $NumberMember = $_POST["NumberMember"];
    $RecrCont = $_POST["RecrCont"];
    $tag = $_POST["tag"];
    $AT_1 = $_POST["AT_1"];
    $AT_2 = $_POST["AT_2"];
    $email = $_POST["email"];

    $TeamName = trim($TeamName);
    $GameId = trim($GameId);
    $NumberMember = trim($NumberMember);
    $RecrCont = trim($RecrCont);
    $tag = implode(",",$tag);
    $AT_1 = trim($AT_1);
    $AT_2 = trim($AT_2);
    $email = trim($email);

    if(strlen($TeamName) == 0){
        $validationMsgs[] = "団名を入力してください。";
    }
    if(strlen($RecrCont) == 0){
        $validationMsgs[] = "募集内容を入力してください。";
    }

    $addRecr = new Member();
    $addRecr->setTeamName($TeamName);
    $addRecr->setGameId($GameId);
    $addRecr->setNumberMember($NumberMember);
    $addRecr->setRecrCont($RecrCont);
    $addRecr->setTag($tag);
    $addRecr->setAt1($AT_1);
    $addRecr->setAt2($AT_2);
    $addRecr->setEmail($email);

    try{
        $db = new PDO(DB_DNS,DB_USERNAME,DB_PASSWORD);
        $process = new MemberRecrDAO($db);
        $result = $process->AddTeam($addRecr);
    }
    catch (PDOException $ex){
        print_r($ex);
        $_SESSION["errorMsg"]="DB接続に失敗しました。";
    }
    finally{
        $db = null;
    }

}
if(isset($_SESSION["errorMsg"])){
    header("location: error.php");
}

if(isset($_SESSION["validationMsgs"])) {
    $validationMsgs=$_SESSION["validationMsgs"];
}
unset($_SESSION["validationMsgs"]);

header("location: MemberRecruitment.php");

<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/shupre/classes/Conf.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/shupre/classes/entity/member.class.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/shupre/classes/dao/FriendRecrDAO.class.php');

$validationMsgs=null;

if(isset($_POST["submit"])){

    $FRecrTitle = $_POST["FRecrTitle"];
    $FRecrCont = $_POST["FRecrCont"];
    $gameID = $_POST["GameId"];
    $Fire = $_POST["Fire"];
    $Water = $_POST["Water"];
    $Earth = $_POST["Earth"];
    $Wind = $_POST["Wind"];
    $Light = $_POST["Light"];
    $Dark = $_POST["Dark"];
    $Free1 = $_POST["Free1"];
    $Free2 = $_POST["Free2"];
    $email = $_POST["email"];
    $fireState = $_POST["FireState"];
    $waterState = $_POST["WaterState"];
    $earthState = $_POST["EarthState"];
    $windState = $_POST["WindState"];
    $lightState = $_POST["LightState"];
    $darkState = $_POST["DarkState"];
    $free1State = $_POST["Free1State"];
    $free2State = $_POST["Free2State"];
    
    $FRecrTitle = trim($FRecrTitle);
    $FRecrCont = trim($FRecrCont);
    $gameID = trim($gameID);
    $Fire = trim($Fire);
    $Water = trim($Water);
    $Earth = trim($Earth);
    $Wind = trim($Wind);
    $Light = trim($Light);
    $Dark = trim($Dark);
    $Free1 = trim($Free1);
    $fireState =trim($fireState);
    $waterState = trim($waterState);
    $earthState = trim($earthState);
    $windState = trim($windState);
    $lightState = trim($lightState);
    $darkState = trim($darkState);
    $free1State = trim($free1State);
    $free2State = trim($free2State);


//バリーデーションチェック
    if(strlen($FRecrTitle) == 0){
        $validationMsgs[] = "募集タイトルを入力してください。";
    }
    if(strlen($FRecrCont) == 0){
        $validationMsgs[] = "募集内容を入力してください。";
    }

//文字列結合
    if(!($Fire == "未設定")){
        $Fire = $Fire."：".$fireState;
    }
    if(!($Water == "未設定")){
        $Water = $Water."：".$waterState;
    }
    if(!($Earth == "未設定")){
        $Earth = $Earth."：".$earthState;
    }
    if(!($Wind == "未設定")){
        $Wind = $Wind."：".$windState;
    }
    if(!($Light == "未設定")){
        $Light = $Light."：".$lightState;
    }
    if(!($Dark == "未設定")){
        $Dark = $Dark."：".$darkState;
    }
    if(!($Free1 == "未設定")){
        $Free1 = $Free1."：".$free1State;
    }
    if(!($Free2 == "未設定")){
        $Free2 = $Free2."：".$free2State;
    }



    $addFriend=new Member();
    $addFriend->setFRecrTitle($FRecrTitle);
    $addFriend->setFRecrCont ($FRecrCont );
    $addFriend->setGameId($gameID);
    $addFriend->setFire($Fire);
    $addFriend->setRecrCont($Water);
    $addFriend->setEarth($Earth);
    $addFriend->setWind($Wind);
    $addFriend->setLight($Light);
    $addFriend->setDark($Dark);
    $addFriend->setFree1($Free1);
    $addFriend->setFree2($Free2);
    $addFriend->setemail($email);
    

    try{
        $db = new PDO(DB_DNS,DB_USERNAME,DB_PASSWORD);
        $process = new FriendRecrDAO($db);
        $result = $process->AddFriend($addFriend);
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

header("location: FriendRecr.php");

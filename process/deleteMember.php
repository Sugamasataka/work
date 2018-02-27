<?php

require_once($_SERVER['DOCUMENT_ROOT'].'/shupre/classes/Conf.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/shupre/classes/entity/member.class.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/shupre/classes/dao/MemberRecrDAO.class.php');


if (isset($_POST['MRid']))
{
    $MRid = $_POST['MRid'];

    $MRid = trim($MRid);

    $deleteRecr = "";
    try{
        $db = new PDO(DB_DNS,DB_USERNAME,DB_PASSWORD);
        $process = new MemberRecrDAO($db);
        $deleteRecr = $process->deleteMemberRecr($MRid);
    }
    catch (PDOException $ex){
        print_r($ex);
        $_SESSION["errorMsg"]="DB接続に失敗しました。";
    }
    finally{
        $db = null;
    }



    header("location:/shupre/recrHistory.php");

}
else
{
    echo 'The parameter of "MRid" is not found.';
}

?>



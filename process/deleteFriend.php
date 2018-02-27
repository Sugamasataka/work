<?php

require_once($_SERVER['DOCUMENT_ROOT'].'/shupre/classes/Conf.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/shupre/classes/entity/member.class.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/shupre/classes/dao/FriendRecrDAO.class.php');


    if (isset($_POST['FRid']))
    {
        $FRid = $_POST['FRid'];

        $FRid = trim($FRid);

        $deleteRecr = "";
        try{
            $db = new PDO(DB_DNS,DB_USERNAME,DB_PASSWORD);
            $process = new FriendRecrDAO($db);
            $deleteRecr = $process->deleteFriendRecr($FRid);
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
        echo 'The parameter of "FRid" is not found.';
    }

?>



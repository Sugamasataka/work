<?php

require_once($_SERVER['DOCUMENT_ROOT'].'/shupre/classes/Conf.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/shupre/classes/entity/member.class.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/shupre/classes/dao/FriendRecrDAO.class.php');

if(isset($_SERVER['HTTP_X_REQUESTED_WITH'])
    && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')
{
    // Ajaxリクエストの場合のみ処理する

    if (isset($_POST['FRid']))
    {
        $FRid = $_POST['FRid'];

        $FRid = trim($FRid);

        $detailRecr = "";
        $db = new PDO(DB_DNS,DB_USERNAME,DB_PASSWORD);
        $process = new FriendRecrDAO($db);
        $detailRecr = $process->detailId($FRid);

        $Contributor = $detailRecr->getEmail();
        $Contributor =$process ->findContributor($Contributor);

        $detail = array(
            'id'=>$detailRecr->getFRid(),
            'Title'=>$detailRecr->getFRecrTitle(),
            'GameID'=>$detailRecr->getGameId(),
            'cont'=>$detailRecr->getFRecrCont(),
            'recrDate'=>$detailRecr->getFRecrDate(),
            'Contributor'=> $Contributor,
            'flame'=>$detailRecr->getFire(),
            'water'=>$detailRecr->getWater(),
            'earth'=>$detailRecr->getEarth(),
            'wind'=>$detailRecr->getWind(),
            'light'=>$detailRecr->getLight(),
            'dark'=>$detailRecr->getDark(),
            'free1'=>$detailRecr->getFree1(),
            'free2'=>$detailRecr->getFree2(),
        );
        //jsonとして出力
        header( "Content-Type: application/json;" ) ;
        $json = json_encode( $detail , JSON_PRETTY_PRINT ) ;
        echo $json;
        exit;
        //ここに何かしらの処理を書く（DB登録やファイルへの書き込みなど）
    }
    else
    {
        echo 'The parameter of "FRid" is not found.';
    }
}
?>



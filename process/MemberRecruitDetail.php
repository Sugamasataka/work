<?php

require_once($_SERVER['DOCUMENT_ROOT'].'/shupre/classes/Conf.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/shupre/classes/entity/member.class.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/shupre/classes/dao/MemberRecrDAO.class.php');

if(isset($_SERVER['HTTP_X_REQUESTED_WITH'])
    && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')
{
    // Ajaxリクエストの場合のみ処理する

    if (isset($_POST['MRid']))
    {
        $MRid = $_POST['MRid'];

        $MRid = trim($MRid);

        $detailRecr = "";
            $db = new PDO(DB_DNS,DB_USERNAME,DB_PASSWORD);
            $process = new MemberRecrDAO($db);
            $detailRecr = $process->detailId($MRid);
            $tags = explode(",",$detailRecr->getTag());
            $tagName = [];
            foreach ($tags as $tag){
                $tagName[] = $process ->TagList($tag);
            }
            $Contributor = $detailRecr->getEmail();
            $Contributor =$process ->findContributor($Contributor);

            $detail = array(
                'id'=>$detailRecr->getMRid(),
                'TeamName'=>$detailRecr->getTeamName(),
                'GameID'=>$detailRecr->getGameId(),
                'cont'=>$detailRecr->getRecrCont(),
                'tag'=>$tagName,
                'AT1'=>$detailRecr->getAt1(),
                'AT2'=>$detailRecr->getAt2(),
                'recrDate'=>$detailRecr->getRecrDate(),
                'Contributor'=> $Contributor,
                'member'=>$detailRecr->getNumberMember()
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
        echo 'The parameter of "MRid" is not found.';
    }
}
?>



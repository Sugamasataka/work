<?php

/**
 * Created by PhpStorm.
 * User: sugamasataka
 * Date: 2017/09/22
 * Time: 10:01
 * フレンド募集ページのDB処理内容
 */
class FriendRecrDAO
{
    public function __construct(PDO $db)
    {
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        $this->db = $db;
    }

    public function FriendRecrALL(){
        $sql="SELECT * FROM FriendRecr ORDER BY FRecr_date DESC ";
        $stmt=$this->db->prepare($sql);
        $result=$stmt->execute();
        $recrList=[];
        while($row=$stmt->fetch(PDO::FETCH_ASSOC)) {
            $FRid = $row["FR_id"];
            $FRecrTitle = $row["FRecr_title"];
            $FRecrCont  = $row["FRecr_Cont"];
            $gameId = $row["game_id"];
            $Fire = $row["Fire"];
            $Water = $row["Water"];
            $Earth = $row["Earth"];
            $Wind = $row["Wind"];
            $Light = $row["Light"];
            $Dark = $row["Dark"];
            $Free1 = $row["Free1"];
            $Free2 = $row["Free2"];
            $email = $row["email"];
            $FRecrDate = $row["FRecr_date"];

            $FRecrCont = mb_substr($FRecrCont,0,90);
            $FRecrCont = nl2br($FRecrCont);

            $FRecrDate = date('Y年m月d日 G時i分',strtotime($FRecrDate));

            $member=new Member();
            $member->setFRid($FRid);
            $member->setFRecrTitle($FRecrTitle);
            $member->setFRecrCont ($FRecrCont );
            $member->setGameId($gameId);
            $member->setFire($Fire);
            $member->setWater($Water);
            $member->setEarth($Earth);
            $member->setWind($Wind);
            $member->setLight($Light);
            $member->setDark($Dark);
            $member->setFree1($Free1);
            $member->setFree2($Free2);
            $member->setGameId($gameId);
            $member->setEmail($email);
            $member->setFRecrDate($FRecrDate);
            $recrList[$FRid]=$member;
        }
        return $recrList;
    }
    public function AddFriend(member $addFriend){
        $sqlinsert = "INSERT INTO FriendRecr(FRecr_title,FRecr_Cont,Fire,Water,Earth,Wind,Light,Dark,Free1,Free2,email,FRecr_date,game_id) VALUES(:FRecr_title,:FRecr_Cont,:Fire,:Water,:Earth,:Wind,:Light,:Dark,:Free1,:Free2,:email,:FRecr_date,:game_id)";
        $stmt = $this->db->prepare($sqlinsert);
        $stmt->bindValue(":FRecr_title", $addFriend->getFRecrTitle(), PDO::PARAM_STR);
        $stmt->bindValue(":FRecr_Cont", $addFriend->getFRecrCont(), PDO::PARAM_STR);
        $stmt->bindValue(":Fire", $addFriend->getFire(), PDO::PARAM_STR);
        $stmt->bindValue(":Water", $addFriend->getRecrCont(), PDO::PARAM_STR);
        $stmt->bindValue(":Earth", $addFriend->getEarth(), PDO::PARAM_STR);
        $stmt->bindValue(":Wind", $addFriend->getWind(), PDO::PARAM_STR);
        $stmt->bindValue(":Light", $addFriend->getLight(), PDO::PARAM_STR);
        $stmt->bindValue(":Dark", $addFriend->getDark(), PDO::PARAM_STR);
        $stmt->bindValue(":Free1", $addFriend->getFree1(), PDO::PARAM_STR);
        $stmt->bindValue(":Free2", $addFriend->getFree2(), PDO::PARAM_STR);
        $stmt->bindValue(":email", $addFriend->getEmail(), PDO::PARAM_STR);
        $stmt->bindValue(":FRecr_date", date("Y-m-d H:i"), PDO::PARAM_INT);
        $stmt->bindValue(":game_id",$addFriend->getGameId(), PDO::PARAM_INT);
        $result = $stmt->execute();
        return $result;
    }
    public function findGameId($email){
        $spl = "SELECT * FROM member WHERE email = :email";
        $stmt = $this->db->prepare($spl);
        $stmt->bindValue(":email", $email, PDO::PARAM_STR);
        $result = $stmt->execute();
        if ($result && $row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $email= $row["game_id"];
        }
        return $email;
    }

    public function detailId($FRid){
        $sql = "select * from friendRecr WHERE FR_id = :FRid";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(":FRid", $FRid ,PDO::PARAM_INT);
        $result=$stmt->execute();
        $member="";
        if($result && $row=$stmt->fetch(PDO::FETCH_ASSOC)) {

            $FRid = $row["FR_id"];
            $FRecrTitle = $row["FRecr_title"];
            $FRecrCont  = $row["FRecr_Cont"];
            $gameId = $row["game_id"];
            $Fire = $row["Fire"];
            $Water = $row["Water"];
            $Earth = $row["Earth"];
            $Wind = $row["Wind"];
            $Light = $row["Light"];
            $Dark = $row["Dark"];
            $Free1 = $row["Free1"];
            $Free2 = $row["Free2"];
            $email = $row["email"];
            $FRecrDate = $row["FRecr_date"];

            $FRecrCont = nl2br($FRecrCont);
            $FRecrDate = date('Y年m月d日 G時i分',strtotime($FRecrDate));

            $member=new Member();
            $member->setFRid($FRid);
            $member->setFRecrTitle($FRecrTitle);
            $member->setFRecrCont ($FRecrCont );
            $member->setGameId($gameId);
            $member->setFire($Fire);
            $member->setWater($Water);
            $member->setEarth($Earth);
            $member->setWind($Wind);
            $member->setLight($Light);
            $member->setDark($Dark);
            $member->setFree1($Free1);
            $member->setFree2($Free2);
            $member->setGameId($gameId);
            $member->setEmail($email);
            $member->setFRecrDate($FRecrDate);
        }
        return $member;
    }
    public function findContributor($Contributor){
        $sql = "select * from member WHERE email = :email";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(":email", $Contributor ,PDO::PARAM_STR);
        $result=$stmt->execute();
        if($result && $row=$stmt->fetch(PDO::FETCH_ASSOC)) {
            $Contributor = $row["member_name"];
        }
        return $Contributor;
    }

    public function recrFriendHistory($email){
        $sql = "select * from FriendRecr where email = :email ORDER BY FRecr_date DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(":email",$email,PDO::PARAM_STR);
        $result = $stmt->execute();
        $friendRecrList = [];
        while($row=$stmt->fetch(PDO::FETCH_ASSOC)) {
            $id = $row["FR_id"];
            $title = $row["FRecr_title"];
            $comment = $row["FRecr_Cont"];
            $date = $row["FRecr_date"];
            $Fire = $row["Fire"];
            $Water = $row["Water"];
            $Earth = $row["Earth"];
            $Wind = $row["Wind"];
            $Light = $row["Light"];
            $Dark = $row["Dark"];
            $Free1 = $row["Free1"];
            $Free2 = $row["Free2"];

            $comment = mb_substr($comment,0,90);
            $comment = nl2br($comment);
            $date = date('Y年m月d日 G時i分',strtotime($date));

            $member = new Member();
            $member->setFRid($id);
            $member->setFRecrTitle($title);
            $member->setFRecrCont($comment);
            $member->setFRecrDate($date);
            $member->setFire($Fire);
            $member->setWater($Water);
            $member->setEarth($Earth);
            $member->setWind($Wind);
            $member->setLight($Light);
            $member->setDark($Dark);
            $member->setFree1($Free1);
            $member->setFree2($Free2);
            $friendRecrList[$id]=$member;

        }
        return $friendRecrList;
    }
    public function deleteFriendRecr($FRid){
        $sql = "delete from friendRecr WHERE FR_id = :FR_id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(":FR_id",$FRid,PDO::PARAM_INT);
        $result = $stmt->execute();
        return $result;
    }
}
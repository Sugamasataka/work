<?php

/**
 * Created by PhpStorm.
 * User: sugamasataka
 * Date: 2018/02/12
 * Time: 17:20
 */
class templateDAO
{
    public function __construct(PDO $db)
    {
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        $this->db = $db;
    }

    public function findTemplateFriend($email){
        $sql = "select * from friend_template where FT_email = :email";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(":email", $email, PDO::PARAM_STR);
        $result=$stmt->execute();
        $member="";
        if($result && $row=$stmt->fetch(PDO::FETCH_ASSOC)) {
            $FTid = $row["FT_id"];
            $FTTitle = $row["FT_title"];
            $FTCont  = $row["FT_cont"];
            $gameId = $row["FT_game_id"];
            $Fire = $row["FT_fire"];
            $Water = $row["FT_water"];
            $Earth = $row["FT_earth"];
            $Wind = $row["FT_wind"];
            $Light = $row["FT_light"];
            $Dark = $row["FT_dark"];
            $Free1 = $row["FT_free1"];
            $Free2 = $row["FT_free2"];
            $email = $row["FT_email"];
            $FTDate = $row["FT_Registration_date"];

            $FTCont = nl2br($FTCont);
            $FTDate = date('Y年m月d日 G時i分',strtotime($FTDate));

            $member=new Member();
            $member->setFRid($FTid);
            $member->setFRecrTitle($FTTitle);
            $member->setFRecrCont ($FTCont );
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
            $member->setFRecrDate($FTDate);
        }
        return $member;
    }


    public function findTemplateMember($email){
        $sql = "select * from member_template where MT_email = :email";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(":email", $email, PDO::PARAM_STR);
        $result=$stmt->execute();
        $member="";
        if($result && $row=$stmt->fetch(PDO::FETCH_ASSOC)) {
            $MTid = $row["MT_id"];
            $TeamName = $row["MT_team_name"];
            $GameId = $row["MT_game_id"];
            $NumberMember = $row["MT_number_member"];
            $RecrCont = $row["MT_cont"];
            $tag = $row["MT_tag"];
            $AT1 = $row["MT_assault_time_1"];
            $AT2 = $row["MT_assault_time_2"];
            $recrDate = $row["MT_date"];

            $RecrCont = nl2br($RecrCont);

            $member = new Member();
            $member->setMRid($MTid);
            $member->setTeamName($TeamName);
            $member->setGameId($GameId);
            $member->setNumberMember($NumberMember);
            $member->setRecrCont($RecrCont);
            $member->setTag($tag);
            $member->setAt1($AT1);
            $member->setAt2($AT2);
            $member->setRecrDate($recrDate);
            $recrList[$MTid] = $member;
        }
        return $member;
    }
    public function TagList($id){
        $sql = "SELECT tag_name from tags WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(":id", $id, PDO::PARAM_INT);
        $result = $stmt->execute();
        $tagName = "";
        if ($result && $row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $tagName = $row["tag_name"];
        }
        return $tagName;
    }

    public function findFriendTemplate($email){
        $sql = "select * from friend_template where FT_email = :email";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(":email", $email, PDO::PARAM_STR);$result=$stmt->execute();
        $member = "";
        if ($result && $row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $member = $row["FT_email"];
        }
        return $member;
    }
    public function findMemberTemplate($email){
        $sql = "select * from member_template where MT_email = :email";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(":email", $email, PDO::PARAM_STR);
        $result=$stmt->execute();
        $member = "";
        if ($result && $row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $member = $row["MT_email"];
        }
        return $member;
    }

    public function AddFriendTemplate(member $addFriend){
        $sqlinsert = "INSERT INTO friend_template(FT_title,FT_cont,FT_game_id,FT_fire,FT_water,FT_earth,FT_wind,FT_light,FT_dark,FT_free1,FT_free2,FT_email,FT_Registration_date) VALUES(:FT_title,:FT_cont,:FT_game_id,:FT_fire,:FT_water,:FT_earth,:FT_wind,:FT_light,:FT_dark,:FT_free1,:FT_free2,:FT_email,:FT_Registration_date)";
        $stmt = $this->db->prepare($sqlinsert);
        $stmt->bindValue(":FT_title", $addFriend->getFRecrTitle(), PDO::PARAM_STR);
        $stmt->bindValue(":FT_cont", $addFriend->getFRecrCont(), PDO::PARAM_STR);
        $stmt->bindValue(":FT_fire", $addFriend->getFire(), PDO::PARAM_STR);
        $stmt->bindValue(":FT_water", $addFriend->getRecrCont(), PDO::PARAM_STR);
        $stmt->bindValue(":FT_earth", $addFriend->getEarth(), PDO::PARAM_STR);
        $stmt->bindValue(":FT_wind", $addFriend->getWind(), PDO::PARAM_STR);
        $stmt->bindValue(":FT_light", $addFriend->getLight(), PDO::PARAM_STR);
        $stmt->bindValue(":FT_dark", $addFriend->getDark(), PDO::PARAM_STR);
        $stmt->bindValue(":FT_free1", $addFriend->getFree1(), PDO::PARAM_STR);
        $stmt->bindValue(":FT_free2", $addFriend->getFree2(), PDO::PARAM_STR);
        $stmt->bindValue(":FT_email", $addFriend->getEmail(), PDO::PARAM_STR);
        $stmt->bindValue(":FT_Registration_date", date("Y-m-d H:i"), PDO::PARAM_INT);
        $stmt->bindValue(":FT_game_id",$addFriend->getGameId(), PDO::PARAM_INT);
        $result = $stmt->execute();
        return $result;
    }
    public function editFriendTemplate(member $addFriend){
        $sql = "update friend_template set FT_title = :FT_title,FT_cont = :FT_cont,FT_game_id = :FT_game_id,FT_fire = :FT_fire,FT_water = :FT_water,FT_earth = :FT_earth,FT_wind = :FT_wind,FT_light = :FT_light,FT_dark = :FT_dark,FT_free1 = :FT_free1,FT_free2 = :FT_free2,FT_Registration_date = :FT_Registration_date WHERE FT_email = :FT_email";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(":FT_title", $addFriend->getFRecrTitle(), PDO::PARAM_STR);
        $stmt->bindValue(":FT_cont", $addFriend->getFRecrCont(), PDO::PARAM_STR);
        $stmt->bindValue(":FT_game_id",$addFriend->getGameId(), PDO::PARAM_INT);
        $stmt->bindValue(":FT_fire", $addFriend->getFire(), PDO::PARAM_STR);
        $stmt->bindValue(":FT_water", $addFriend->getRecrCont(), PDO::PARAM_STR);
        $stmt->bindValue(":FT_earth", $addFriend->getEarth(), PDO::PARAM_STR);
        $stmt->bindValue(":FT_wind", $addFriend->getWind(), PDO::PARAM_STR);
        $stmt->bindValue(":FT_light", $addFriend->getLight(), PDO::PARAM_STR);
        $stmt->bindValue(":FT_dark", $addFriend->getDark(), PDO::PARAM_STR);
        $stmt->bindValue(":FT_free1", $addFriend->getFree1(), PDO::PARAM_STR);
        $stmt->bindValue(":FT_free2", $addFriend->getFree2(), PDO::PARAM_STR);
        $stmt->bindValue(":FT_email", $addFriend->getEmail(), PDO::PARAM_STR);
        $stmt->bindValue(":FT_Registration_date", date("Y-m-d H:i"), PDO::PARAM_INT);

        $result = $stmt->execute();
        return $result;
    }
    public function addMemberTemplate(member $addMember){

        $sqlinsert = "INSERT INTO member_template(MT_team_name,MT_game_id,MT_number_member,MT_cont,MT_tag,MT_assault_time_1,MT_assault_time_2,MT_email,MT_date) VALUES(:team_name,:game_id,:number_member,:Recr_cont,:tag,:Assault_time_1,:Assault_time_2,:email,:recr_date)";
        $stmt = $this->db->prepare($sqlinsert);
        $stmt->bindValue(":team_name", $addMember->getTeamName(), PDO::PARAM_STR);
        $stmt->bindValue(":game_id", $addMember->getGameId(), PDO::PARAM_STR);
        $stmt->bindValue(":number_member", $addMember->getNumberMember(), PDO::PARAM_INT);
        $stmt->bindValue(":Recr_cont", $addMember->getRecrCont(), PDO::PARAM_STR);
        $stmt->bindValue(":tag", $addMember->getTag(), PDO::PARAM_STR);
        $stmt->bindValue(":Assault_time_1", $addMember->getAt1(), PDO::PARAM_INT);
        $stmt->bindValue(":Assault_time_2", $addMember->getAt2(), PDO::PARAM_INT);
        $stmt->bindValue(":email", $addMember->getEmail(), PDO::PARAM_STR);
        $stmt->bindValue(":recr_date",date("Y-m-d H:i"), PDO::PARAM_STR);
        $result = $stmt->execute();
        return $result;
    }

    public function editMemberTemplate(member $addMember){
        $sql = "update member_template set MT_team_name = :team_name,MT_game_id = :game_id,MT_number_member = :number_member,MT_cont = :Recr_cont,MT_tag = :tag,MT_assault_time_1 = :assault_time_1,MT_assault_time_2 = :assault_time_2,MT_date = :recr_date WHERE MT_email = :email";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(":team_name", $addMember->getTeamName(), PDO::PARAM_STR);
        $stmt->bindValue(":game_id", $addMember->getGameId(), PDO::PARAM_STR);
        $stmt->bindValue(":number_member", $addMember->getNumberMember(), PDO::PARAM_INT);
        $stmt->bindValue(":Recr_cont", $addMember->getRecrCont(), PDO::PARAM_STR);
        $stmt->bindValue(":tag", $addMember->getTag(), PDO::PARAM_STR);
        $stmt->bindValue(":assault_time_1", $addMember->getAt1(), PDO::PARAM_INT);
        $stmt->bindValue(":assault_time_2", $addMember->getAt2(), PDO::PARAM_INT);
        $stmt->bindValue(":email", $addMember->getEmail(), PDO::PARAM_STR);
        $stmt->bindValue(":recr_date",date("Y-m-d H:i"), PDO::PARAM_STR);
        $result = $stmt->execute();
        return $result;
    }
}
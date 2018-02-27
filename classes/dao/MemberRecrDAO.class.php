<?php

/**
 * Created by PhpStorm.
 * User: sugamasataka
 * Date: 2017/09/22
 * Time: 10:01
 * 団員募集ページのDB処理内容
 */
class MemberRecrDAO
{
    /**
     * @var PDO DB接続オブジェクト
     */
    private $db;
    /**
     * コンストラクタ
     *
     * @param PDO $db DB接続オブジェクト
     */
    public function __construct(PDO $db) {
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        $this->db=$db;
    }

    public function MemberRecrAll(){
        $sql="SELECT * FROM Member_Recr ORDER BY MR_id DESC ";
        $stmt=$this->db->prepare($sql);
        $result=$stmt->execute();
        $recrList=[];
        while($row=$stmt->fetch(PDO::FETCH_ASSOC)) {
            $MRid = $row["MR_id"];
            $TeamName = $row["team_name"];
            $GameId = $row["game_id"];
            $NumberMember = $row["number_member"];
            $RecrCont = $row["Recr_cont"];
            $tag = $row["tag"];
            $AT1 = $row["Assault_time_1"];
            $AT2 = $row["Assault_time_2"];
            $recrDate = $row["recr_date"];

            $RecrCont = mb_substr($RecrCont,0,90);
            $RecrCont = nl2br($RecrCont);

            $recrDate = date('Y年m月d日 G時i分',strtotime($recrDate));

            $member=new Member();
            $member->setMRid($MRid);
            $member->setTeamName($TeamName);
            $member->setGameId($GameId);
            $member->setNumberMember($NumberMember);
            $member->setRecrCont($RecrCont);
            $member->setTag($tag);
            $member->setAt1($AT1);
            $member->setAt2($AT2);
            $member->setRecrDate($recrDate);
            $recrList[$MRid]=$member;
        }
        return $recrList;
    }
    public function AddTeam(member $addRecr){

        $sqlinsert = "INSERT INTO member_Recr(team_name,game_id,number_member,Recr_cont,tag,Assault_time_1,Assault_time_2,email,recr_date) VALUES(:team_name,:game_id,:number_member,:Recr_cont,:tag,:Assault_time_1,:Assault_time_2,:email,:recr_date)";
        $stmt = $this->db->prepare($sqlinsert);
        $stmt->bindValue(":team_name", $addRecr->getTeamName(), PDO::PARAM_STR);
        $stmt->bindValue(":game_id", $addRecr->getGameId(), PDO::PARAM_STR);
        $stmt->bindValue(":number_member", $addRecr->getNumberMember(), PDO::PARAM_STR);
        $stmt->bindValue(":Recr_cont", $addRecr->getRecrCont(), PDO::PARAM_STR);
        $stmt->bindValue(":tag", $addRecr->getTag(), PDO::PARAM_STR);
        $stmt->bindValue(":Assault_time_1", $addRecr->getAt1(), PDO::PARAM_INT);
        $stmt->bindValue(":Assault_time_2", $addRecr->getAt2(), PDO::PARAM_INT);
        $stmt->bindValue(":email", $addRecr->getEmail(), PDO::PARAM_STR);
        $stmt->bindValue(":recr_date",date("Y-m-d H:i"), PDO::PARAM_STR);
        $result = $stmt->execute();
        return $result;
    }
    public function TagList($id){
       $sql = "SELECT tag_name from tags WHERE id = :id";
       $stmt = $this->db->prepare($sql);
       $stmt->bindValue(":id",$id,PDO::PARAM_INT);
       $result = $stmt->execute();
       $tagName = "";
        if($result && $row=$stmt->fetch(PDO::FETCH_ASSOC)) {
            $tagName = $row["tag_name"];
           }
       return $tagName;
    }
    public function FindTag($tag){
        $sql = "select * from member_recr WHERE tag LIKE :tag ORDER BY recr_date DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(":tag", "%".$tag."%" ,PDO::PARAM_STR);
        $result=$stmt->execute();
        $recrList=[];
        while($row=$stmt->fetch(PDO::FETCH_ASSOC)) {
            $MRid = $row["MR_id"];
            $TeamName = $row["team_name"];
            $GameId = $row["game_id"];
            $NumberMember = $row["number_member"];
            $RecrCont = $row["Recr_cont"];
            $tag = $row["tag"];
            $AT1 = $row["Assault_time_1"];
            $AT2 = $row["Assault_time_2"];
            $recrDate = $row["recr_date"];

            $RecrCont = mb_substr($RecrCont,0,70);
            $RecrCont = nl2br($RecrCont);

            $member = new Member();
            $member->setMRid($MRid);
            $member->setTeamName($TeamName);
            $member->setGameId($GameId);
            $member->setNumberMember($NumberMember);
            $member->setRecrCont($RecrCont);
            $member->setTag($tag);
            $member->setAt1($AT1);
            $member->setAt2($AT2);
            $member->setRecrDate($recrDate);
            $recrList[$MRid] = $member;
        }
        return $recrList;
    }

    public function detailId($MRid){
        $sql = "select * from member_recr WHERE MR_id = :MRid";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(":MRid", $MRid ,PDO::PARAM_INT);
        $result=$stmt->execute();
        $member="";
        if($result && $row=$stmt->fetch(PDO::FETCH_ASSOC)) {

            $MRid = $row["MR_id"];
            $TeamName = $row["team_name"];
            $GameId = $row["game_id"];
            $NumberMember = $row["number_member"];
            $RecrCont = $row["Recr_cont"];
            $tag = $row["tag"];
            $AT1 = $row["Assault_time_1"];
            $AT2 = $row["Assault_time_2"];
            $recrDate = $row["recr_date"];
            $email = $row["email"];

            $recrDate = date('Y年m月d日 G時i分',strtotime($recrDate));
            $RecrCont = nl2br($RecrCont);

            $member = new Member();
            $member->setMRid($MRid);
            $member->setTeamName($TeamName);
            $member->setGameId($GameId);
            $member->setNumberMember($NumberMember);
            $member->setRecrCont($RecrCont);
            $member->setTag($tag);
            $member->setAt1($AT1);
            $member->setAt2($AT2);
            $member->setRecrDate($recrDate);
            $member->setEmail($email);
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
    public function recrMemberHistory($email){
    $sql="SELECT * FROM Member_Recr where email = :email ORDER BY Recr_date DESC ";
    $stmt=$this->db->prepare($sql);
    $stmt->bindValue(":email", $email ,PDO::PARAM_STR);
    $result=$stmt->execute();
    $recrList=[];
    while($row=$stmt->fetch(PDO::FETCH_ASSOC)) {
        $MRid = $row["MR_id"];
        $TeamName = $row["team_name"];
        $GameId = $row["game_id"];
        $NumberMember = $row["number_member"];
        $RecrCont = $row["Recr_cont"];
        $tag = $row["tag"];
        $AT1 = $row["Assault_time_1"];
        $AT2 = $row["Assault_time_2"];
        $recrDate = $row["recr_date"];

        $RecrCont = mb_substr($RecrCont,0,90);
        $RecrCont = nl2br($RecrCont);

        $recrDate = date('Y年m月d日 G時i分',strtotime($recrDate));

        $member=new Member();
        $member->setMRid($MRid);
        $member->setTeamName($TeamName);
        $member->setGameId($GameId);
        $member->setNumberMember($NumberMember);
        $member->setRecrCont($RecrCont);
        $member->setTag($tag);
        $member->setAt1($AT1);
        $member->setAt2($AT2);
        $member->setRecrDate($recrDate);
        $recrList[$MRid]=$member;
    }
    return $recrList;
}
    public function deleteMemberRecr($MRid){
        $sql = "delete from member_recr WHERE MR_id = :MR_id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(":MR_id",$MRid,PDO::PARAM_INT);
        $result = $stmt->execute();
        return $result;
    }
}
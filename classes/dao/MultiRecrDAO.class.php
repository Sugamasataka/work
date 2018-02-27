<?php

/**
 * Created by PhpStorm.
 * User: sugamasataka
 * Date: 2017/09/27
 * Time: 10:15
 */
class MultiRecrDAO
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

    public function MultiRecrAll(){
        $sql="SELECT * FROM Multi_Recr ORDER BY Multi_id DESC ";
        $stmt=$this->db->prepare($sql);
        $result=$stmt->execute();
        $recrList=[];
        while($row=$stmt->fetch(PDO::FETCH_ASSOC)) {
            $MultiID = $row["Multi_id"];
            $QuestName = $row["Quest_Name"];
            $JoinID = $row["Join_id"];
            $MRecrCont = $row["Multi_Recr_Cont"];
            $email = $row["email"];

            $member=new Member();
            $member->setMultiID($MultiID);
            $member->setQuestName($QuestName);
            $member->setJoinID($JoinID);
            $member->setMRecrCont($MRecrCont);
            $member->setemail($email);
            $recrList[$MultiID]=$member;
        }
        return $recrList;
    }
    public function AddMulti(member $addRecr){
        $sql = "SELECT COUNT(*) FROM Multi_Recr";
        $sqlinsert = "INSERT INTO Multi_Recr(Multi_id,Quest_Name,Join_id,Multi_Recr_cont,email) VALUES(:Multi_id,:Quest_Name,:Join_id,:Multi_Recr_cont,:email)";

        $stmt = $this->db->prepare($sql);
        $result = $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $count = $row["COUNT(*)"];
        $count++;
        $stmt = $this->db->prepare($sqlinsert);
        $stmt->bindValue(":Multi_id",$count,PDO::PARAM_INT);
        $stmt->bindValue(":Quest_Name", $addRecr->getQuestName(), PDO::PARAM_STR);
        $stmt->bindValue(":Join_id", $addRecr->getJoinID(), PDO::PARAM_STR);
        $stmt->bindValue(":Multi_Recr_cont", $addRecr->getMRecrCont(), PDO::PARAM_STR);
        $stmt->bindValue(":email", $addRecr->getEmail(), PDO::PARAM_STR);
        $result = $stmt->execute();
        return $result;
    }
}
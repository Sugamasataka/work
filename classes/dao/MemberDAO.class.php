<?php

/**
 * Created by PhpStorm.
 * User: sugamasataka
 * Date: 2017/09/22
 * Time: 10:08
 */
class MemberDAO
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

    public function login($email){
        $sqlserch = "SELECT * FROM member WHERE email = :email";
        $stmt = $this->db->prepare($sqlserch);
        $stmt->bindValue(":email",$email,PDO::PARAM_STR);
        $result = $stmt->execute();

        if ($result && $row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $MemberName = $row["member_name"];
            $member = new Member();
            $member ->setMemberName($MemberName);
        }
    }

    public function mypage($email){
        $sql = "SELECT * FROM member WHERE email = :email";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(":email",$email,PDO::PARAM_STR);
        $result = $stmt->execute();
        $member = "";
        if ($result && $row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $id = $row["member_id"];
            $MemberName = $row["member_name"];
            $profile = $row["profile"];
            $icon = $row["icon"];

            $profile = htmlentities($profile, ENT_QUOTES, 'UTF-8');
            $profile = nl2br($profile);

            $member = new Member();
            $member->setMemberID($id);
            $member->setMemberName($MemberName);
            $member->setprofile($profile);
            $member->setIcon($icon);

        }
        return $member;
    }


    public function editProfile(member $member){
        $sql = "UPDATE member set member_name = :member_name, profile = :profile, icon = :icon WHERE member_id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(":id",$member->getMemberID(),PDO::PARAM_INT);
        $stmt->bindValue(":member_name",$member->getMemberName(),PDO::PARAM_STR);
        $stmt->bindValue(":profile",$member->getProfile(),PDO::PARAM_STR);
        $stmt->bindValue(":icon",$member->getIcon(),PDO::PARAM_STR);
        $result = $stmt->execute();
        return $result;
    }
    public function signUp(member $member){
        $sql = "insert into member(member_name,email,profile,password,icon) VALUE (:member_name,:email,'よろしくおねがいします。',:pass,'images/character/gran.png')";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(":member_name",$member->getMemberName(),PDO::PARAM_STR);
        $stmt->bindValue(":email",$member->getEmail(),PDO::PARAM_STR);
        $stmt->bindValue(":pass",$member->getPass(),PDO::PARAM_STR);
        $result = $stmt->execute();
        return $result;
    }

}
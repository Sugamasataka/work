<?php

/**
 * Created by PhpStorm.
 * User: sugamasataka
 * Date: 2017/08/27
 * Time: 20:06
 */
class Member
{

    /**
     * =============ユーザー情報===================
     */
    /**
     * ユーザーID
     */
    private $memberID = "";
    /**
     * ユーザー名
     */
    private $MemberName = "";
    /**
     * プロフィール
     *
     */
    private $profile = "";
    /**
     * メールアドレス
     */
    private $email = "";
    /**
     * パスワード
     */
    private $pass = "";
    /**
     * 認証用パスワード
     */
    private $dbPass = "";
    /**
     * ユーザーのアイコン
     */
    private $icon = "";



    public function getMemberID()
    {
        return $this->memberID;
    }

    public function setMemberID($memberID)
    {
        $this->memberID = $memberID;
    }
    public function getMemberName()
    {
        return $this->MemberName;
    }

    public function setMemberName($MemberName)
    {
        $this->MemberName = $MemberName;
    }

    public function getProfile()
    {
        return $this->profile;
    }

    public function setProfile($profile)
    {
        $this->profile = $profile;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getPass()
    {
        return $this->pass;
    }

    public function setPass($pass)
    {
        $this->pass = $pass;
    }

    public function getdbPass()
    {
        return $this->dbPass;
    }

    public function setdbPass($dbPass)
    {
        $this->dbPass = $dbPass;
    }

    public function getIcon()
    {
        return $this->icon;
    }

    public function setIcon($icon)
    {
        $this->icon = $icon;
    }

    /**
     *==================団募集==========================
     *
     * 団募集のID
     */
    private $MRid = "";
    /**
     * 団名
     */
    private $TeamName = "";
    /**
     * ゲームのID
     */
    private $GameId = "";
    /**
     * 現在の団員数
     */
    private $NumberMember = "";
    /**
     * 募集内容
     */
    private $RecrCont = "";
    /**
     * タグ
     */
    private $tag = "";
    /**
     * アサルトタイム1
     */
    private $AT_1 = "";
    /**
     * アサルトタイム2
     */
    private $AT_2 = "";
    /**
     * 登録日
     */
    private $RecrDate = "";

    public function getMRid()
    {
        return $this->MRid;
    }

    public function setMRid($MRid)
    {
        $this->MRid = $MRid;
    }

    public function setTeamName($TeamName)
    {
        $this->TeamName = $TeamName;
    }

    public function getTeamName()
    {
        return $this->TeamName;
    }

    public function getGameId()
    {
        return $this->GameId;
    }

    public function setGameId($GameId)
    {
        $this->GameId = $GameId;
    }

    public function getNumberMember()
    {
        return $this->NumberMember;
    }

    public function setNumberMember($NumberMember)
    {
        $this->NumberMember = $NumberMember;
    }

    public function getRecrCont()
    {
        return $this->RecrCont;
    }

    public function setRecrCont($RecrCont)
    {
        $this->RecrCont = $RecrCont;
    }

    public function getTag()
    {
        return $this->tag;
    }

    public function setTag($tag)
    {
        $this->tag = $tag;
    }

    public function getAt1()
    {
        return $this->AT_1;
    }

    public function setAt1($AT_1)
    {
        $this->AT_1 = $AT_1;
    }

    public function getAt2()
    {
        return $this->AT_2;
    }

    public function setAt2($AT_2)
    {
        $this->AT_2 = $AT_2;
    }

    public function getRecrDate()
    {
        return $this->RecrDate;
    }

    public function setRecrDate($RecrDate)
    {
        $this->RecrDate = $RecrDate;
    }

    /**
     *==================フレンド募集======================
     *
     * フレンド募集のID
     */
    private $FRid = "";
    /**
     * フレンド募集のタイトル
     */
    private $FRecrTitle = "";
    /**
     * フレンド募集の内容
     */
    private $FRecrCont = "";
    /**
     * フレンド募集のサポート召喚石(火)
     */
    private $Fire = "";
    /**
     * フレンド募集のサポート召喚石(水)
     */
    private $Water = "";
    /**
     * フレンド募集のサポート召喚石(土)
     */
    private $Earth = "";
    /**
     * フレンド募集のサポート召喚石(風)
     */
    private $Wind = "";
    /**
     * フレンド募集のサポート召喚石(光)
     */
    private $Light = "";
    /**
     * フレンド募集のサポート召喚石(闇)
     */
    private $Dark = "";
    /**
     * フレンド募集のサポート召喚石(フリー1)
     */
    private $Free1 = "";
    /**
     * フレンド募集のサポート召喚石(フリー2)
     */
    private $Free2 = "";

    /**
     * フレンド募集投稿日
     */
    private $FRecrDate = "";


    public function getFRid()
    {
        return $this->FRid;
    }

    public function setFRid($FRid)
    {
        $this->FRid = $FRid;
    }

    public function getFRecrTitle()
    {
        return $this->FRecrTitle;
    }

    public function setFRecrTitle($FRecrTitle)
    {
        $this->FRecrTitle = $FRecrTitle;
    }

    public function getFRecrCont()
    {
        return $this->FRecrCont;
    }

    public function setFRecrCont($FRecrCont)
    {
        $this->FRecrCont = $FRecrCont;
    }

    public function getFire()
    {
        return $this->Fire;
    }

    public function setFire($Fire)
    {
        $this->Fire = $Fire;
    }

    public function getWater()
    {
        return $this->Water;
    }

    public function setWater($Water)
    {
        $this->Water = $Water;
    }

    public function getEarth()
    {
        return $this->Earth;
    }

    public function setEarth($Earth)
    {
        $this->Earth = $Earth;
    }

    public function getWind()
    {
        return $this->Wind;
    }

    public function setWind($Wind)
    {
        $this->Wind = $Wind;
    }

    public function getLight()
    {
        return $this->Light;
    }

    public function setLight($Light)
    {
        $this->Light = $Light;
    }

    public function getDark()
    {
        return $this->Dark;
    }

    public function setDark($Dark)
    {
        $this->Dark = $Dark;
    }

    public function getFree1()
    {
        return $this->Free1;
    }

    public function setFree1($Free1)
    {
        $this->Free1 = $Free1;
    }

    public function getFree2()
    {
        return $this->Free2;
    }

    public function setFree2($Free2)
    {
        $this->Free2 = $Free2;
    }

    public function getFRecrDate()
    {
        return $this->FRecrDate;
    }

    public function setFRecrDate($FRecrDate)
    {
        $this->FRecrDate = $FRecrDate;
    }
}

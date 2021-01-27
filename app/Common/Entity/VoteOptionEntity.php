<?php
/**
 * Created by shaofeng
 * Date: 2021/1/8 10:36
 */

namespace App\Common\Entity;


class VoteOptionEntity implements BaseDao
{
    public $id;

    public $voteId;

    public $optionName;

    public $votes;

    public $createTime;

    public $updateTime;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getVoteId()
    {
        return $this->voteId;
    }

    /**
     * @param mixed $voteId
     */
    public function setVoteId($voteId): void
    {
        $this->voteId = $voteId;
    }

    /**
     * @return mixed
     */
    public function getOptionName()
    {
        return $this->optionName;
    }

    /**
     * @param mixed $optionName
     */
    public function setOptionName($optionName): void
    {
        $this->optionName = $optionName;
    }

    /**
     * @return mixed
     */
    public function getVotes()
    {
        return $this->votes;
    }

    /**
     * @param mixed $votes
     */
    public function setVotes($votes): void
    {
        $this->votes = $votes;
    }

    /**
     * @return mixed
     */
    public function getCreateTime()
    {
        return $this->createTime;
    }

    /**
     * @param mixed $createTime
     */
    public function setCreateTime($createTime): void
    {
        $this->createTime = $createTime;
    }

    /**
     * @return mixed
     */
    public function getUpdateTime()
    {
        return $this->updateTime;
    }

    /**
     * @param mixed $updateTime
     */
    public function setUpdateTime($updateTime): void
    {
        $this->updateTime = $updateTime;
    }


}
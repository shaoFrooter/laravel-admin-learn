<?php
/**
 * Created by shaofeng
 * Date: 2021/1/8 15:04
 */

namespace App\Common\Entity;


class VoteRecordEntity implements BaseDao
{
    public $id;

    public $voteId;

    public $voteOptionId;

    public $operatorId;

    public $operatorName;

    public $createTime;

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
    public function getVoteOptionId()
    {
        return $this->voteOptionId;
    }

    /**
     * @param mixed $voteOptionId
     */
    public function setVoteOptionId($voteOptionId): void
    {
        $this->voteOptionId = $voteOptionId;
    }

    /**
     * @return mixed
     */
    public function getOperatorId()
    {
        return $this->operatorId;
    }

    /**
     * @param mixed $operatorId
     */
    public function setOperatorId($operatorId): void
    {
        $this->operatorId = $operatorId;
    }

    /**
     * @return mixed
     */
    public function getOperatorName()
    {
        return $this->operatorName;
    }

    /**
     * @param mixed $operatorName
     */
    public function setOperatorName($operatorName): void
    {
        $this->operatorName = $operatorName;
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



}
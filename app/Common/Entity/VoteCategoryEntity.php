<?php
/**
 * Created by shaofeng
 * Date: 2021/1/8 10:33
 */

namespace App\Common\Entity;


class VoteCategoryEntity implements BaseDao
{
    public $id;

    public $title;

    public $voteType;

    public $creatorId;

    public $startTime;

    public $endTime;

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
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title): void
    {
        $this->title = $title;
    }

    /**
     * @return mixed
     */
    public function getVoteType()
    {
        return $this->voteType;
    }

    /**
     * @param mixed $voteType
     */
    public function setVoteType($voteType): void
    {
        $this->voteType = $voteType;
    }

    /**
     * @return mixed
     */
    public function getCreatorId()
    {
        return $this->creatorId;
    }

    /**
     * @param mixed $creatorId
     */
    public function setCreatorId($creatorId): void
    {
        $this->creatorId = $creatorId;
    }

    /**
     * @return mixed
     */
    public function getStartTime()
    {
        return $this->startTime;
    }

    /**
     * @param mixed $startTime
     */
    public function setStartTime($startTime): void
    {
        $this->startTime = $startTime;
    }

    /**
     * @return mixed
     */
    public function getEndTime()
    {
        return $this->endTime;
    }

    /**
     * @param mixed $endTime
     */
    public function setEndTime($endTime): void
    {
        $this->endTime = $endTime;
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
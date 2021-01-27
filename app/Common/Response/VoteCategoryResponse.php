<?php
/**
 * Created by shaofeng
 * Date: 2021/1/7 17:03
 */

namespace App\Common\Response;


class VoteCategoryResponse
{
    public $id;

    public $title;

    public $voteType;

    public $createTime;

    public $updateTime;

    public $startTime;

    public $endTime;

    public $voteOptions;

    public $voted;

    public $checkArray=[];

    public $radioSelect;

    public $started;

    public $creatorId;

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
    public function getVoteOptions()
    {
        return $this->voteOptions;
    }

    /**
     * @param mixed $voteOptions
     */
    public function setVoteOptions($voteOptions): void
    {
        $this->voteOptions = $voteOptions;
    }

    /**
     * @return mixed
     */
    public function getVoted()
    {
        return $this->voted;
    }

    /**
     * @param mixed $voted
     */
    public function setVoted($voted): void
    {
        $this->voted = $voted;
    }

    /**
     * @return mixed
     */
    public function getCheckArray()
    {
        return $this->checkArray;
    }

    /**
     * @param mixed $checkArray
     */
    public function setCheckArray($checkArray): void
    {
        $this->checkArray = $checkArray;
    }

    /**
     * @return mixed
     */
    public function getRadioSelect()
    {
        return $this->radioSelect;
    }

    /**
     * @param mixed $radioSelect
     */
    public function setRadioSelect($radioSelect): void
    {
        $this->radioSelect = $radioSelect;
    }

    /**
     * @return mixed
     */
    public function getStarted()
    {
        return $this->started;
    }

    /**
     * @param mixed $started
     */
    public function setStarted($started): void
    {
        $this->started = $started;
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

}
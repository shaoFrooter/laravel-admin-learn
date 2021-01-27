<?php
/**
 * Created by shaofeng
 * Date: 2021/1/7 17:09
 */

namespace App\Common\Info;


class VoteOptionInfo
{
    public $id;

    public $voteId;

    public $optionName;

    public $votes;

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



}
<?php
/**
 * Created by shaofeng
 * Date: 2020/12/31 16:58
 */

namespace App\Service;


interface VoteService
{
    public function queryValidVoteList(int $pageNo,int $pageSize);

    public function vote($voteId,array $voteOption);

    public function detail($id);

    public function userVoteList($creatorId,$pageNo,$pageSize);

    public function deleteById($id);

    public function createVote($title,$VoteType,$startTime,$endTime,array $optionNames);

    public function updateVote($id,$title,$voteType,$startTime,$endTime,array $optionNames);

}
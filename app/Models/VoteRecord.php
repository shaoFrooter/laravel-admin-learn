<?php
/**
 * Created by shaofeng
 * Date: 2020/12/28 15:13
 */

namespace App\Models;


class VoteRecord extends BaseModel
{
    protected $table = 'vote_record';

    protected $mappingPath = 'mapping/voteRecord.php';

    public function deleteByVoteId($voteId){
        return $this->newQuery()->where('vote_id',$voteId)->delete();
    }

    public function selectByVoteIdAndOperatorId($voteId,$operatorId){
        $dataArray=$this->newQuery()->where('operator_id',$operatorId)->where('vote_id',$voteId)->get()->toArray();
        return $this->convert2Object($dataArray);
    }

    public function selectByOperatorIdAndVoteIdList($operatorId,$voteIdList){
        $dataArray=$this->newQuery()->where('operator_id',$operatorId)->whereIn('vote_id',$voteIdList)->get()->toArray();
        return $this->convert2Object($dataArray);
    }

}
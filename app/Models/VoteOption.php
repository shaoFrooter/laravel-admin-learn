<?php
/**
 * Created by shaofeng
 * Date: 2020/12/31 16:12
 */

namespace App\Models;


class VoteOption extends BaseModel
{
    protected $table = 'vote_option';
    public $timestamps = false;
    protected $fillable=['vote_id','option_name'];
    protected $mappingPath = 'mapping/voteOption.php';

    public function deleteByVoteId($voteId){
        return $this->newQuery()->where('vote_id',$voteId)->delete();
    }

    public function voteCategory(){
        return $this->belongsTo(VoteCategory::class,'vote_id');
    }

    public function selectByVoteIdList(array $voteIdList){
        $dataArray=$this->newQuery()->whereIn('vote_id',$voteIdList)->get()->toArray();
        return $this->convert2Object($dataArray);
    }

    public function selectByVoteId($voteId){
        $dataArray=$this->newQuery()->where('vote_id',$voteId)->get()->toArray();
        return $this->convert2Object($dataArray);
    }

    public function updateVotesBatch(array $voteId,$votes){
        $this->newQuery()->whereIn('id',$voteId)->increment('votes',$votes);
    }
}
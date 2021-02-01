<?php
/**
 * Created by shaofeng
 * Date: 2020/12/31 16:13
 */

namespace App\Models;

use App\Common\Entity\VoteCategoryEntity;

class VoteCategory extends BaseModel
{
    protected $table = 'vote_category';
    protected $mappingPath = 'mapping/voteCategory.php';
    public $timestamps = false;

    public function countByCreatorId($creatorId){
        return $this->newQuery()->where('creator_id',$creatorId)->count();
    }

    public function selectByCreatorId($creatorId,$pageNo,$pageSize){
        $dataArray=$this->newQuery()->where('creator_id',$creatorId)->orderBy('id','desc')->forPage($pageNo,$pageSize)->get()->toArray();
        return $this->convert2Object($dataArray);
    }

    public function countValidVoteCategory($dateNow){
       return $this->newQuery()->where('start_time','<',$dateNow)->where('end_time','>',$dateNow)->count();
    }

    public function voteOptions(){
        return $this->hasMany(VoteOption::class,'vote_id');
    }

    public function voteOptionsMorp(){
        return $this->morphMany(VoteOption::class,'vote');
    }

    public function queryValidVoteCategory($dateNow,int $pageNo,int $pageSize){
        $dataArray=$this->newQuery()->where('start_time','<',$dateNow)->where('end_time','>',$dateNow)->orderBy('id','desc')->forPage($pageNo,$pageSize)->get()->toArray();
        return $this->convert2Object($dataArray);
    }

    public function selectByIdWithEntity($id){
        return $this->convert2Entity($this->selectById($id));
    }

    private function convert2Entity(array $dataArray)
    {
        $this->dbMapping();
        if (empty($dataArray)) {
            return null;
        }
        $entity = new VoteCategoryEntity();
        $entity->setId($dataArray['id']);
        $entity->setTitle($dataArray['title']);
        $entity->setVoteType($dataArray['vote_type']);
        $entity->setCreatorId($dataArray['creator_id']);
        $entity->setStartTime($dataArray['start_time']);
        $entity->setEndTime($dataArray['end_time']);
        $entity->setCreateTime($dataArray['create_time']);
        $entity->setUpdateTime($dataArray['update_time']);
        return $entity;
    }
}
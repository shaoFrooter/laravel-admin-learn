<?php
/**
 * Created by shaofeng
 * Date: 2020/12/31 16:58
 */

namespace App\Service\impl;


use App\Common\Constant\CommonCode;
use App\Common\Entity\VoteCategoryEntity;
use App\Common\Entity\VoteOptionEntity;
use App\Common\Entity\VoteRecordEntity;
use App\Common\Exception\VoteException;
use App\Common\Info\VoteOptionInfo;
use App\Common\Query\QueryResponse;
use App\Common\Query\ResultResponse;
use App\Common\Response\VoteCategoryResponse;
use App\Common\Util\CommonUtil;
use App\Common\Util\DateUtil;
use App\Common\Util\UserUtil;
use App\Models\VoteCategory;
use App\Models\VoteOption;
use App\Models\VoteRecord;
use App\Service\long;
use App\Service\VoteService;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class VoteServiceImpl implements VoteService
{

    private $voteCategory;

    private $voteOption;

    private $voteRecord;

    public function __construct(VoteCategory $voteCategory, VoteOption $voteOption,VoteRecord $voteRecord)
    {
        $this->voteCategory = $voteCategory;
        $this->voteOption = $voteOption;
        $this->voteRecord = $voteRecord;
    }

    /**
     * @param int $pageNo
     * @param int $pageSize
     * @return ResultResponse
     * 获取进行中的投票列表
     */
    public function queryValidVoteList(int $pageNo, int $pageSize)
    {
        //获取当前进行中的投票数量
        $count = $this->voteCategory->countValidVoteCategory(now());
        if ($count == 0) {
            return ResultResponse::success('ok', null);
        }
        $offset = ($pageNo - 1) * $pageSize;
        $queryResponse = new QueryResponse();
        $queryResponse->setTotal($count);
        if ($offset >= $count) {
            $queryResponse->setTotal([]);
            return ResultResponse::success(null, $queryResponse);
        }
        $dataArray = $this->voteCategory->queryValidVoteCategory(now(), $pageNo, $pageSize);
        //获取所有的id
        $idList = [];
        $dataArrayMap = [];
        foreach ($dataArray as $item) {
            array_push($idList, $item['id']);
            $dataArrayMap[$item['id']] = $item;
        }
        $voteOptionArray = $this->voteOption->selectByVoteIdList($idList);
        $voteOptionMap=[];
        foreach ($voteOptionArray as $item) {
            $idString=(string)$item['voteId'];
            if(array_key_exists($idString,$voteOptionMap)){
                array_push($voteOptionMap[$idString], $item);
            }else{
                $voteOptionMap[$idString] = [];
                array_push($voteOptionMap[$idString], $item);
            }
        }
        $resultDataArray = [];
        //查询用户投票记录
        $loginUser=UserUtil::getUserId()!=null;
        $votedList=[];
        if($loginUser){
            $votedRecordList=$this->voteRecord->selectByOperatorIdAndVoteIdList(UserUtil::getUserId(),$idList);
            foreach($votedRecordList as $item){
                $idString=(string)$item['voteId'];
                if(array_key_exists($idString,$votedList)){
                    array_push($votedList[$idString],$item['voteOptionId']);
                }else{
                    $votedList[$idString]=[];
                    array_push($votedList[$idString],$item['voteOptionId']);
                }
            }
        }
        foreach ($idList as $id) {
            $voteCategory = $dataArrayMap[$id];
            $subVoteOption = $voteOptionMap[$id];
            $voteCategoryResponse = new VoteCategoryResponse();
            $voteCategoryResponse->setId($id);
            $voteCategoryResponse->setTitle($voteCategory['title']);
            $voteCategoryResponse->setVoteType($voteCategory['voteType']);
            $voteCategoryResponse->setStartTime($voteCategory['startTime']);
            $voteCategoryResponse->setEndTime($voteCategory['endTime']);
            $voteCategoryResponse->setCreateTime($voteCategory['createTime']);
            $voteCategoryResponse->setUpdateTime($voteCategory['updateTime']);
            $dateNow=now();
            $voteCategoryResponse->setStarted($dateNow->isAfter($voteCategoryResponse->getStartTime()));
            //设置是否已投票
            $voteCategoryResponse->setVoted(false);
            if($loginUser) {
                $idString = (string)$id;
                if(array_key_exists($idString,$votedList)) {
                    $currentVotedItem = $votedList[$idString];
                    if ($currentVotedItem != null) {
                        $voteCategoryResponse->setVoted(true);
                        if($voteCategoryResponse->getVoteType()==1){
                            $voteCategoryResponse->setRadioSelect($currentVotedItem[0]);
                        }else {
                            $voteCategoryResponse->setCheckArray($currentVotedItem);
                        }
                    }
                }
            }
            $voteOptionInfoList = [];
            foreach ($subVoteOption as $item) {
                $voteOptionInfo = new VoteOptionInfo();
                $voteOptionInfo->setId($item['id']);
                $voteOptionInfo->setOptionName($item['optionName']);
                $voteOptionInfo->setVoteId($item['voteId']);
                $voteOptionInfo->setVotes($item['votes']);
                array_push($voteOptionInfoList, $voteOptionInfo);
            }
            $voteCategoryResponse->setVoteOptions($voteOptionInfoList);
            array_push($resultDataArray, $voteCategoryResponse);

        }
        $queryResponse->setData($resultDataArray);
        return ResultResponse::success('', $queryResponse);
    }

    /**
     * @param $voteId
     * @param $voteType
     * @param array $voteOption
     * @return false|string
     * 1、投票是否存在或过期
     * 2、用户是否已经投票
     * 3、单选投票，多选投票
     */
    public function vote($voteId, array $voteOption)
    {
        //查询投票时间是否已经截止
        $voteCategoryEntity = $this->voteCategory->selectByIdWithEntity($voteId);
        if ($voteCategoryEntity == null) {
            return ResultResponse::fail(CommonCode::ERROR, '未查询到当前投票', null);
        }
        $startTime = $voteCategoryEntity->getStartTime();
        $endTime = $voteCategoryEntity->getEndTime();
        $dateNow=now();
        if ($dateNow->isBefore($startTime)) {
            return ResultResponse::fail(CommonCode::ERROR, '当前投票还未开始', null);
        }
        if ($dateNow->isAfter($endTime)) {
            return ResultResponse::fail(CommonCode::ERROR, '当前投票已经结束', null);
        }
        $userId=UserUtil::getUserId();
        $existData=$this->voteRecord->selectByVoteIdAndOperatorId($voteId,$userId);
        if(!empty($existData)) {
            return ResultResponse::fail(CommonCode::ERROR, '已投票', null);
        }
        //校验投票选项
        $optionArray=$this->voteOption->selectByVoteId($voteId);
        if(empty($optionArray)){
            return ResultResponse::fail(CommonCode::ERROR, '投票选项不存在', null);
        }
        $optionIdArray=[];
        foreach ($optionArray as $item){
            array_push($optionIdArray,$item['id']);
        }
        foreach ($voteOption as $item){
            if(!in_array($item,$optionIdArray)){
                return ResultResponse::fail(CommonCode::ERROR, '投票选项不存在', null);
            }
        }
        $voteType=$voteCategoryEntity->getVoteType();
        //可以开始投票
        if ($voteType == 1) {
            //单选票
            $voteRecord = new VoteRecordEntity();
            $voteRecord->setVoteId($voteId);
            $voteRecord->setVoteOptionId($voteOption[0]);
            $voteRecord->setOperatorId($userId);
            $voteRecord->setCreateTime(DateUtil::today());
            DB::transaction(function () use ($voteRecord, $voteOption) {
                $this->voteRecord->insertModel($voteRecord);
                $this->voteOption->incrementById($voteOption[0], 'votes', 1);
            });
            return ResultResponse::success(null, '投票成功');

        }
        if ($voteType == 2) {
            //向记录表批量插入记录
            $recordCollection = new Collection();
            foreach ($voteOption as $item) {
                $voteRecord = new VoteRecordEntity();
                $voteRecord->setVoteId($voteId);
                $voteRecord->setVoteOptionId($item);
                $voteRecord->setOperatorId($userId);
                $voteRecord->setOperatorName('');
//                $voteRecord->setCreateTime(now());
                $recordCollection->add($voteRecord);
            }
            DB::transaction(function () use ($recordCollection, $voteOption) {
                $this->voteRecord->insertModelBatch($recordCollection);
                $this->voteOption->updateVotesBatch($voteOption, 1);
            });
            return ResultResponse::success(null, '投票成功');
        }
    }

    public function detail($id)
    {
        $voteCategory = $this->voteCategory->selectByIdWithEntity($id);
        if ($voteCategory == null) {
            throw new VoteException('当前投票不存在');
        }
        $idArray = [];
        array_push($idArray, $id);
        $dataArray = $this->voteOption->selectByVoteIdList($idArray);
        return $this->buildVoteCategoryResponse($voteCategory, $dataArray);
    }

    private function buildVoteCategoryResponse(VoteCategoryEntity $categoryEntity,array $optionArray){
        $voteCategoryResponse=new VoteCategoryResponse();
        $voteCategoryResponse->setId($categoryEntity->getId());
        $voteCategoryResponse->setTitle($categoryEntity->getTitle());
        $voteCategoryResponse->setVoteType($categoryEntity->getVoteType());
        $voteCategoryResponse->setCreateTime($categoryEntity->getCreateTime());
        $voteCategoryResponse->setUpdateTime($categoryEntity->getUpdateTime());
        $voteCategoryResponse->setStartTime($categoryEntity->getStartTime());
        $voteCategoryResponse->setEndTime($categoryEntity->getEndTime());
        $voteCategoryResponse->setCreatorId($categoryEntity->getCreatorId());
        $options=[];
        foreach($optionArray as $item){
            $voteOptionInfo = new VoteOptionInfo();
            $voteOptionInfo->setId($item['id']);
            $voteOptionInfo->setOptionName($item['optionName']);
            $voteOptionInfo->setVoteId($item['voteId']);
            $voteOptionInfo->setVotes($item['votes']);
            array_push($options,$voteOptionInfo);
        }
        $voteCategoryResponse->setVoteOptions($options);
        return $voteCategoryResponse;
    }

    public function userVoteList($creatorId, $pageNo, $pageSize)
    {
        if(CommonUtil::isNull($creatorId)){
            return ResultResponse::fail(CommonCode::ERROR,'用户不存在',null);
        }
        $total = $this->voteCategory->countByCreatorId($creatorId);
        if ($total == 0) {
            return ResultResponse::success('ok', null);
        }
        $offset = ($pageNo - 1) * $pageSize;
        $queryResponse = new QueryResponse();
        $queryResponse->setTotal($total);
        if ($offset >= $total) {
            $queryResponse->setTotal([]);
            return ResultResponse::success(null, $queryResponse);
        }
        $dataArray = $this->voteCategory->selectByCreatorId($creatorId, $pageNo, $pageSize);
        $queryResponse->setData($this->buildVoteCategoryEntity($dataArray));
        return ResultResponse::success(null,$queryResponse);
    }

    private function buildVoteCategoryEntity(array  $dataArray)
    {
        $arr = [];
        foreach ($dataArray as $item) {
            $entity = new VoteCategoryResponse();
            $entity->setId($item['id']);
            $entity->setTitle($item['title']);
            $entity->setVoteType($item['voteType']);
            $entity->setStartTime($item['startTime']);
            $entity->setEndTime($item['endTime']);
            $entity->setCreateTime($item['createTime']);
            $entity->setUpdateTime($item['updateTime']);
            $dateNow=now();
            $entity->setStarted($dateNow->isAfter($entity->getStartTime()));
            array_push($arr, $entity);
        }
        return $arr;
    }

    public function deleteById($id)
    {
        if (CommonUtil::isEmpty($id)) {
            return ResultResponse::fail(CommonCode::ERROR, '不存在当前id', null);
        }
        $existEntity = $this->voteCategory->selectByIdWithEntity($id);
        if (empty($existEntity)) {
            return ResultResponse::fail(CommonCode::ERROR, '当前投票不存在');
        }
        DB::transaction(function () use ($id) {
            $this->voteCategory->deleteById($id);
            $this->voteOption->deleteByVoteId($id);
            $this->voteRecord->deleteByVoteId($id);
        });
        return ResultResponse::success('投票成功', null);
    }

    public function createVote($title, $voteType, $startTime, $endTime, array $optionNames)
    {
        $voteCategory = $this->createVoteCategoryEntity($title, $voteType, $startTime, $endTime);
        $voteId = DB::transaction(function () use ($voteCategory, $optionNames) {
            $voteId = $this->voteCategory->insertModel($voteCategory);
            $optionArray = $this->createVoteOption($optionNames, $voteId);
            $this->voteOption->insertModelBatch($optionArray);
            return $voteId;
        });
        return ResultResponse::success(null, $voteId);
    }

    private function createVoteCategoryEntity($title, $voteType, $startTime, $endTime):VoteCategoryEntity
    {
        $voteCategory = new VoteCategoryEntity();
        $voteCategory->setTitle($title);
        $voteCategory->setVoteType($voteType);
        $voteCategory->setStartTime(DateUtil::formatDateDefault(DateUtil::number2Date($startTime)));
        $voteCategory->setEndTime(DateUtil::formatDateDefault(DateUtil::number2Date($endTime)));
        $voteCategory->setCreatorId(UserUtil::getUserId());
        return $voteCategory;
    }

    private function createVoteOption(array $optionNames,$voteId):Collection
    {
        $optionArray = new Collection();
        foreach ($optionNames as $item) {
            $option = new VoteOptionEntity();
            $option->setVoteId($voteId);
            $option->setOptionName($item['optionName']);
            $optionArray->add($option);
        }
        return $optionArray;
    }

    public function updateVote($id, $title, $voteType, $startTime, $endTime, array $optionNames)
    {
        $this->updateCheck($id,$startTime,$endTime);
        $voteCategory = $this->createVoteCategoryEntity($title, $voteType, $startTime, $endTime);
        $voteCategory->setId($id);
        $optionArray = $this->createVoteOption($optionNames, $id);
        $voteId = DB::transaction(function () use ($voteCategory, $optionArray, $id) {
            $this->voteOption->deleteByVoteId($id);
            $this->voteCategory->updateModelById($voteCategory);
            $this->voteOption->insertModelBatch($optionArray);
            return $id;
        });
        return ResultResponse::success(null, $voteId);
    }

    private function dateCheck($startTime,$endTime):bool
    {
        $startTimeDate = DateUtil::number2Date($startTime);
        $endTimeDate = DateUtil::number2Date($endTime);
        if ($startTimeDate->isBefore($endTimeDate)) {
            return true;
        }
        return false;
    }

    private function updateCheck($id,$startTime,$endTime)
    {
        if(!$this->dateCheck($startTime,$endTime)){
            throw new VoteException('开始时间不可晚于结束时间');
        }
        $entity = $this->voteCategory->selectByIdWithEntity($id);
        if ($entity == null) {
            throw new VoteException('id=' . $id . ' 不存在');
        }
        $existStartTime = $entity->getStartTime();
        $dateNow = now();
        if ($dateNow->isAfter($existStartTime)) {
            throw new VoteException('投票已经开始无法编辑');
        }
        if ($entity->getCreatorId() != UserUtil::getUserId()) {
            throw new VoteException('无编辑权限');
        }
    }

}
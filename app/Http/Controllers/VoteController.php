<?php
/**
 * Created by shaofeng
 * Date: 2021/1/6 15:23
 */

namespace App\Http\Controllers;


use App\Common\Query\ResultResponse;
use App\Common\Util\JsonUtil;
use App\Common\Util\UserUtil;
use App\Models\VoteCategory;
use App\Service\VoteService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class VoteController extends Controller
{
    private $voteService;

    private $voteCategory;

    public function __construct(VoteService $voteService,VoteCategory $voteCategory)
    {
        $this->voteService = $voteService;
        $this->voteCategory=$voteCategory;
    }

    public function voteList(Request $request){
        $pageNo=$request->get('pageNo');
        $pageSize=$request->get('pageSize');
        return JsonUtil::toJson($this->voteService->queryValidVoteList($pageNo,$pageSize));
    }

    public function addVote(Request $request){
        $optionArray=$request->get('options');
        $voteId=$request->get('voteId');
        return JsonUtil::toJson($this->voteService->vote($voteId,$optionArray));
    }

    public function createVote(Request $request){
        $title=$request->get('title');
        $voteType=$request->get('voteType');
        $startTime=$request->get('startTime');
        $endTime=$request->get('endTime');
        $optionNames=$request->get('optionNames');
        return JsonUtil::toJson($this->voteService->createVote($title,$voteType,$startTime,$endTime,$optionNames));
    }

    public function updateVote(Request $request){
        $id=$request->get('id');
        $title=$request->get('title');
        $voteType=$request->get('voteType');
        $startTime=$request->get('startTime');
        $endTime=$request->get('endTime');
        $optionNames=$request->get('optionNames');
        return JsonUtil::toJson($this->voteService->updateVote($id,$title,$voteType,$startTime,$endTime,$optionNames));
    }

    public function detail(Request $request)
    {
        $id = $request->get('id');
        $detailResponse = $this->voteService->detail($id);
        return JsonUtil::toJson(ResultResponse::success(null, $detailResponse));
    }

    public function deleteByVoteId(Request $request){
        return JsonUtil::toJson($this->voteService->deleteById($request->get('id')));

    }

    public function myVoteList(Request $request){
        $pageNo=$request->get('pageNo');
        $pageSize=$request->get('pageSize');
        return JsonUtil::toJson($this->voteService->userVoteList(UserUtil::getUserId(),$pageNo,$pageSize));
    }

}
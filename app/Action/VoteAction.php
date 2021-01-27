<?php
/**
 * Created by shaofeng
 * Date: 2020/12/28 15:32
 */

namespace App\Action;


use App\Models\VoteCandidate;
use App\Models\VoteRecord;
use Encore\Admin\Actions\RowAction;
use Encore\Admin\Facades\Admin;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class VoteAction extends RowAction
{
    public $name = '投票';

    public function dialog(){
        $this->confirm('确认投票？');
    }

    public function handle(Model $model)
    {
        $loginUser=Admin::user();
        //登录用户id
        $loginUserId=$loginUser->id;
        $voteRecord=new VoteRecord();
        $modelId=$model['id'];
        $oldRecord=$voteRecord->newQuery()->where('candidate_id',$modelId)->where('operator_id',$loginUserId)->first();
        if($oldRecord!=null){
            //抛出异常
            return $this->response()->warning('不可重复投票')->refresh();
        }
        //插入记录
        DB::transaction(function ()use($voteRecord,$modelId,$loginUserId,$model,$loginUser){
            $voteRecord->newQuery()->insertGetId(['candidate_id'=>$modelId,'operator_id'=>$loginUserId,'candidate_nick_name'=>$model['nick_name'],'operator_name'=>$loginUser['name']]);
            $voteCandidate=new VoteCandidate();
            //票数增加1
            $voteCandidate->newQuery()->where('id',$modelId)->increment('votes',1);
        });

        return $this->response()->success('投票成功')->refresh();
    }
}
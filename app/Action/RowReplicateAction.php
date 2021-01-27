<?php
/**
 * Created by shaofeng
 * Date: 2020/12/22 14:38
 */

namespace App\Action;


use Encore\Admin\Actions\RowAction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class RowReplicateAction extends RowAction
{
    public $name='复制';
    public function handle(Model $model,Request $request){
        $key=$model->getKey();
        $type=$request->get('type');
        $reason=$request->get('reason');
        return $this->response()->success('copy success')->refresh();
    }

//    public function dialog(){
//        $this->confirm('确认复制？');
//    }

    public function form(){
        $type=[1=>'广告',2=>'违法',3=>'钓鱼'];
        $this->radio('type','类型')->options($type);
        $this->textarea('reason','原因')->rules('required');
    }

    public function authorize($user,$model){
        $id=$user['id'];
        $modelId=$model['id'];
        return false;
    }
}
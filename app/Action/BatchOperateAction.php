<?php
/**
 * Created by shaofeng
 * Date: 2020/12/22 14:56
 */

namespace App\Action;


use Encore\Admin\Actions\BatchAction;
use Illuminate\Database\Eloquent\Collection;

class BatchOperateAction extends BatchAction
{
    public $name='批量操作';

    public function handle(Collection $collection){
        foreach ($collection as $item){
            $val=$item['id'];
            echo $val;
        }
        return $this->response()->success('批量操作成功')->refresh();
    }

}
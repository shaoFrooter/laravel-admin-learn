<?php
/**
 * Created by shaofeng
 * Date: 2020/12/23 14:30
 */

namespace App\Forms;


use Encore\Admin\Widgets\Form;
use Illuminate\Http\Request;

class MovieForm extends Form
{
    public $title='电影管理';

    public function handle(Request $request)
    {
        $request->get('id');
    }

    public function form(){
        $this->number('rate', '打分');
        $this->datetime('release_at', '发布时间');
    }

}
<?php
/**
 * Created by shaofeng
 * Date: 2020/12/22 15:17
 */

namespace App\Action;


use Encore\Admin\Actions\Action;
use Illuminate\Http\Request;

class ImportFileAction extends Action
{
    public $name = '导入数据';

    protected $selector = '.import-post';

    public function handle(Request $request)
    {
        $myFile = $request->file('file');
        $fileName=$myFile->getClientOriginalName();
        $myFile->storeAs('tmp',$fileName);
        return $this->response()->success('导入成功')->refresh();
    }

    public function form()
    {
        $this->file('file', '请选择文件');
    }

    public function html()
    {
        return <<<HTML
        <a class="btn btn-sm btn-default import-post"><i class="fa fa-upload"></i>导入数据</a>
HTML;
    }


}
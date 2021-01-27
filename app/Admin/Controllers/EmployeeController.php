<?php

namespace App\Admin\Controllers;

use App\Action\BatchOperateAction;
use App\Action\BatchUpdateAction;
use App\Action\ExportFileAction;
use App\Action\ImportFileAction;
use App\Action\RowReplicateAction;
use App\Models\Employee;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class EmployeeController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Employee';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Employee());

        $grid->column('id', __('Id'));
        $grid->column('no', __('No'));
        $grid->column('name', __('Name'));
        $grid->column('mail', __('Mail'));
        $grid->column('password', __('Password'));
        $grid->column('department', __('Department'));
        $grid->column('avatar', __('Avatar'))->downloadable('http://localhost/uploads/');
        $grid->column('create_time', __('Create time'));
        $grid->column('update_time', __('Update time'));
        $options=[1=>'选择1',
            2=>'选择2',
            3=>'选择3',
            4=>'选择4',];
//        $grid->column('status', __('状态'))->editable('select',$options);
//        $grid->column('status')->switch();
        $grid->column('status')->radio($options);
//        $grid->column('status');
        //增加一个操作
        $grid->actions(function ($actions){
           $actions->add(new RowReplicateAction());
        });
//        //增加一个批量操作
        $grid->batchActions(function ($batch){
            $batch->add(new BatchOperateAction());
        });
        //导入数据
        $grid->tools(function (Grid\Tools $tools){
            $tools->append(new ImportFileAction());
        });
        //导出数据
        $grid->exporter(new ExportFileAction());
        //开启快速搜索
        $grid->quickSearch('name','mail','department');
        //规格选择器
        $grid->selector(function (Grid\Tools\Selector $selector){
            $selector->select('name','姓名',[
               1=>'邵锋',
               2=>'小米',
               3=>'OPPO',
            ]);
            $selector->select('department','部门',[
                1=>'财务部',
                2=>'社会事业部',
            ]);
            $selector->select('no','编号',['0-99','100-999','1000-9999'],function ($query,$value){
                $between=[[0,99],[100,999],[1000,9999]];
                $query->whereBetween('no',$between[$value]);
            });
        });
        $grid->tools(function ($tools){
            $tools->batch(function ($batch){
                $batch->add('发布',new BatchUpdateAction(1));
                $batch->add('下线',new BatchUpdateAction(0));
            });
        });
        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(Employee::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('no', __('No'));
        $show->field('name', __('Name'));
        $show->field('mail', __('Mail'));
        $show->field('password', __('Password'));
        $show->field('department', __('Department'));
        $show->field('avatar', __('Avatar'));
        $show->field('create_time', __('Create time'));
        $show->field('update_time', __('Update time'));
        $show->field('status', __('Status'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Employee());

        $form->number('no', __('No'));
        $form->text('name', __('Name'));
        $form->email('mail', __('Mail'))->default('');
        $form->password('password', __('Password'))->default('');
        $form->text('department', __('Department'));
        $form->image('avatar', __('Avatar'));
        $form->datetime('create_time', __('Create time'))->default(date('Y-m-d H:i:s'));
        $form->datetime('update_time', __('Update time'))->default(date('Y-m-d H:i:s'));
        $form->radio('status', __('Status'))->options([1=>'已知',2=>'未知',3=>'不可知']);

        return $form;
    }
}

<?php

namespace App\Admin\Controllers;

use App\Action\VoteAction;
use App\Models\VoteCandidate;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class VoteCandidateController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'VoteCandidate';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new VoteCandidate());
        $grid->column('id', __('Id'));
        $grid->column('nick_name', '昵称')->qrcode();
//        $grid->column('email', '邮箱');
        $grid->column('avatar', '头像')->image('http://localhost/uploads/',50,50);
        $grid->column('votes', '票数');
//        $grid->column('vote','投票')->button();
        //增加昵称的模糊搜索
        $grid->quickSearch('nick_name')->placeholder('输入昵称');
        $grid->disableFilter();
        //指定排序方式
        $grid->model()->orderByDesc('votes');
        $grid->model()->orderByDesc('id');
        //根据权限判断是否显示其他菜单
        if(!Admin::user()->can('update:operate:permission')){
            $grid->disableColumnSelector();
            $grid->disableCreateButton();
            $grid->disableBatchActions();
            $grid->disableExport();
            $grid->actions(function ($actions){
                $actions->disableDelete();
                $actions->disableEdit();
                $actions->disableView();
                $actions->add(new VoteAction());
            });
        }else{
            $grid->actions(function ($actions){
                $actions->add(new VoteAction());
            });
        }
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
        $show = new Show(VoteCandidate::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('nick_name', '昵称');
        $show->field('email', '邮箱');
        $show->field('avatar', '头像');
        $show->field('votes', __('Votes'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new VoteCandidate());

        $form->text('nick_name','昵称');
        $form->email('email', '邮箱');
        $form->image('avatar', '头像');
//        $form->number('votes', __('Votes'));

        return $form;
    }
}

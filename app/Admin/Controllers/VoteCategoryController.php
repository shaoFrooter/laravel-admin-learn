<?php

namespace App\Admin\Controllers;

use App\Models\VoteCategory;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Illuminate\Support\Facades\Auth;

class VoteCategoryController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'VoteCategory';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new VoteCategory());

        $grid->column('id', __('Id'));
        $grid->column('title', __('Title'));
        $grid->column('vote_type', __('Vote type'))->display(function ($vote_type){
            if($vote_type==1){
                return '单选';
            }
            if($vote_type==2){
                return '多选';
            }
        });
        $grid->column('start_time', __('Start time'));
        $grid->column('end_time', __('End time'));
        $grid->column('creator_id', __('Creator Id'));
        $grid->column('create_time', __('Create time'));
        $grid->column('update_time', __('Update time'));
        $grid->model()->orderBy('id','desc');

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
        $show = new Show(VoteCategory::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('title', __('Title'));
        $show->field('vote_type', __('Vote type'))->as(function ($voteType){
            if($voteType==1){
                return '单选';
            }
            if($voteType==2){
                return '多选';
            }
        });
        $show->field('create_time', __('Create time'));
        $show->field('update_time', __('Update time'));
        $show->field('end_time', __('End time'));
        $show->voteOptions('选项',function ($voteOptions){
            $voteOptions->id();
            $voteOptions->column('option_name');
            $voteOptions->column('votes');
            $voteOptions->disableCreateButton();
            $voteOptions->disableFilter();
            $voteOptions->disableExport();
            $voteOptions->disableRowSelector();
            $voteOptions->disableActions();
            $voteOptions->disableColumnSelector();
        });
        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new VoteCategory());

        $form->text('title', __('Title'));
        $form->radio('vote_type', '类型')->options([1=>'单选票',2=>'多选票']);
        $form->hasMany('voteOptions',function (Form\NestedForm $form){
            $form->text('option_name','选项');
            $form->text('id');
        });
        $form->submitted(function (Form $form){
            $model=$form->model();
            $model['creator_id']=Auth::id();
        });
//        $form->text('creator_id')->disable()->default(Auth::id());
//        $form->morphMany('voteOptionsMorp','选项',function (Form\NestedForm $form){
//            $form->text('option_name');
//        });
        //todo 隐藏创建者id
        $form->datetime('start_time', __('Start time'))->default(date('Y-m-d H:i:s'));
        $form->datetime('end_time', __('End time'))->default(date('Y-m-d H:i:s'));
        return $form;
    }
}

<?php

namespace App\Admin\Controllers;

use App\Forms\MovieForm;
use App\Models\Movie;
use Encore\Admin\Auth\Permission;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;
use Illuminate\Http\Request;

class MovieController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Movie';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Movie());

        $grid->column('id', __('Id'));
        $grid->column('title', __('Title'));
        $grid->column('director', __('Director'));
        $grid->column('rate', __('Rate'));
        $grid->column('release_at', __('Release at'));
        $grid->column('create_time', __('Create time'));
        $grid->column('update_time', __('Update time'));
        $grid->column('describe', __('Describe'));

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
        $show = new Show(Movie::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('title', __('Title'));
        $show->field('director', __('Director'));
        $show->field('rate', __('Rate'));
        $show->field('release_at', __('Release at'));
        $show->field('create_time', __('Create time'));
        $show->field('update_time', __('Update time'));
        $show->field('describe', __('Describe'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Movie());

        $form->display('id', 'ID');
        $form->keyValue('title')->rules('required|min:5');
//        $form->list('title')->rules('required|min:5')->min(2)->max(10);
//        $form->text('title', __('Title'))->required();
//        $directors = [
//            1 => 'John',
//            2 => 'Smith',
//            3 => 'Kate',
//        ];
//        $form->select('director', '导演')->options($directors);
        //添加滑动
        $form->slider('director','电影')->options([
        'max'       => 100,
        'min'       => 1,
        'step'      => 1,
        'postfix'   => 'years old'
    ]);
        $form->number('rate', '打分');
        $form->datetime('release_at', '发布时间');
        $form->datetime('create_time', '创建时间');
        $form->datetime('update_time', '更新时间');
        $form->textarea('describe', '简介');
        $form->footer(function ($footer) {
            // 去掉`查看`checkbox
            $footer->disableViewCheck();
            // 去掉`继续编辑`checkbox
            $footer->disableEditingCheck();
            // 去掉`继续创建`checkbox
            $footer->disableCreatingCheck();
        });
        if ($form->isCreating()) {
            $form->confirm('确定提交吗', 'create');
        }
        if($form->isEditing()){
            $form->confirm('确定提交吗', 'edit');
        }
        return $form;
    }

    public function movieForm(Content $content){
        return $content->title('电影管理')->body(new MovieForm());
    }

}

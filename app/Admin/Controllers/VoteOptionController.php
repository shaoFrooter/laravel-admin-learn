<?php

namespace App\Admin\Controllers;

use App\Models\VoteOption;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class VoteOptionController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'VoteOption';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new VoteOption());

        $grid->column('id', __('Id'));
        $grid->column('vote_id', __('Vote id'));
        $grid->column('option_name', __('Option name'));
        $grid->column('create_time', __('Create time'));
        $grid->column('update_time', __('Update time'));
        $grid->column('votes', __('Votes'));

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
        $show = new Show(VoteOption::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('vote_id', __('Vote id'));
        $show->field('option_name', __('Option name'));
        $show->field('create_time', __('Create time'));
        $show->field('update_time', __('Update time'));
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
        $form = new Form(new VoteOption());

        $form->number('vote_id', __('Vote id'));
        $form->text('option_name', __('Option name'));
        $form->datetime('create_time', __('Create time'))->default(date('Y-m-d H:i:s'));
        $form->datetime('update_time', __('Update time'))->default(date('Y-m-d H:i:s'));
        $form->number('votes', __('Votes'));

        return $form;
    }
}

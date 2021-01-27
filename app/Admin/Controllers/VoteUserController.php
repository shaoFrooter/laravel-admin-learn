<?php

namespace App\Admin\Controllers;

use App\Models\VoteUser;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class VoteUserController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'VoteUser';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new VoteUser());

        $grid->column('id', __('Id'));
        $grid->column('nick_name', __('Nick name'));
        $grid->column('password', __('Password'));
        $grid->column('avatar', __('Avatar'));
        $grid->column('create_time', __('Create time'));
        $grid->column('update_time', __('Update time'));

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
        $show = new Show(VoteUser::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('nick_name', __('Nick name'));
        $show->field('password', __('Password'));
        $show->field('avatar', __('Avatar'));
        $show->field('create_time', __('Create time'));
        $show->field('update_time', __('Update time'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new VoteUser());

        $form->text('nick_name', __('Nick name'));
        $form->password('password', __('Password'));
        $form->image('avatar', __('Avatar'));
        $form->datetime('create_time', __('Create time'))->default(date('Y-m-d H:i:s'));
        $form->datetime('update_time', __('Update time'))->default(date('Y-m-d H:i:s'));

        return $form;
    }
}

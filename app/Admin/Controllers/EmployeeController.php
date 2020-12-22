<?php

namespace App\Admin\Controllers;

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
        $grid->column('avatar', __('Avatar'));

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
        $form->email('mail', __('Mail'));
        $form->password('password', __('Password'));
        $form->text('department', __('Department'));
        $form->image('avatar', __('Avatar'));

        return $form;
    }
}

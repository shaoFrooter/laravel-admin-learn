<?php

namespace App\Admin\Controllers;

use App\Models\Salary;
use Encore\Admin\Auth\Permission;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;
use Illuminate\Support\Facades\Gate;

class SalaryController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Salary';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Salary());

        $grid->column('id', __('Id'));
        $grid->column('income', __('Income'));
        $grid->column('create_time', __('Create time'))->filter('date');
        $grid->column('update_time', __('Update time'));
        $grid->column('employee_id', __('Employee id'));
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
        $show = new Show(Salary::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('income', __('Income'));
        $show->field('create_time', __('Create time'));
        $show->field('update_time', __('Update time'));
        $show->field('employee_id', __('Employee id'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Salary());

        $form->number('income', __('Income'));
        $form->datetime('create_time', __('Create time'))->default(date('Y-m-d H:i:s'));
        $form->datetime('update_time', __('Update time'))->default(date('Y-m-d H:i:s'));
        $form->number('employee_id', __('Employee id'));
        return $form;
    }

    public function create(Content $content)
    {
        //校验是否具有权限
        Permission::check('salary:manage:create');
        return parent::create($content);
    }
}

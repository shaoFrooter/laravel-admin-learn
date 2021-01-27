<?php

namespace App\Admin\Controllers;

use App\Models\Painter;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class PainterController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Painter';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Painter());

        $grid->column('id', __('Id'));
        $grid->column('username', __('Username'));
        $grid->column('bio', __('Bio'));

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
        $show = new Show(Painter::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('username', __('Username'));
        $show->field('bio', __('Bio'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Painter());

        $form->text('username', __('Username'));
        $form->textarea('bio', __('Bio'));

        $form->hasMany('painting','画作',function (Form\NestedForm $form){
            $form->text('title');
            $form->image('body');
            $form->datetime('completed-at');

    });

        return $form;
    }
}

<?php

namespace App\Admin\Controllers;

use App\Models\VoteRecord;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class VoteRecordController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '投票记录';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new VoteRecord());

        $grid->column('id', __('Id'));
        $grid->column('candidate_id', '候选者id');
        $grid->column('candidate_nick_name', '候选者');
        $grid->column('operator_id', '投票人id');
        $grid->column('operator_name', '投票人');
        $grid->column('create_time', '投票时间');

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
        $show = new Show(VoteRecord::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('candidate_id', __('Candidate id'));
        $show->field('operator_id', __('Operator id'));
        $show->field('create_time', __('Create time'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new VoteRecord());

        $form->number('candidate_id', __('Candidate id'));
        $form->text('candidate_nick_name', '候选者');
        $form->number('operator_id', __('Operator id'));
        $form->text('operator_name', '投票人');
        $form->datetime('create_time', __('Create time'))->default(date('Y-m-d H:i:s'));

        return $form;
    }
}

<?php
/**
 * Created by shaofeng
 * Date: 2020/12/22 16:07
 */

namespace App\Action;


use Encore\Admin\Grid\Exporters\ExcelExporter;
use Maatwebsite\Excel\Concerns\WithMapping;

class ExportFileAction extends ExcelExporter implements WithMapping
{
    protected $fileName = '员工列表.xlsx';

    protected $columns = [
        'no' => '编号',
        'name' => '姓名',
        'department' => '部门',
        'create_time' => '创建时间'];

    public function map($employee): array
    {
        return [
            $employee->no,
            $employee->name . '123',
            $employee->status == 1 ? 'yes' : 'no'
        ];
    }
}
<?php
/**
 * Created by shaofeng
 * Date: 2020/12/22 10:51
 */

namespace App\Show;


use App\Models\Employee;
use App\Models\Salary;
use Illuminate\Contracts\Support\Renderable;

class SalaryShow implements Renderable
{
    public function render($key=null)
    {
        $salary=new Employee();
        $salaryResult=$salary->newQuery()->find($key);
        return 'http://localhost/uploads'.$salaryResult['avatar'];
    }


}
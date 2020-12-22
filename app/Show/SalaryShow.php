<?php
/**
 * Created by shaofeng
 * Date: 2020/12/22 10:51
 */

namespace App\Show;


use App\Models\Salary;
use Illuminate\Contracts\Support\Renderable;

class SalaryShow implements Renderable
{
    public function render($key=null)
    {
        $salary=new Salary();
        dump($salary->newQuery()->where('id',$key)->get()->toArray());
    }


}
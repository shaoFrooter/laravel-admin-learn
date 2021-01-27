<?php
/**
 * Created by shaofeng
 * Date: 2020/12/23 13:56
 */

namespace App\Models;


use Encore\Admin\Traits\ModelTree;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use ModelTree;

    protected $table='category';

    public $timestamps = false;

}
<?php
/**
 * Created by shaofeng
 * Date: 2020/12/22 19:58
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    protected $table = 'movie';
    public $timestamps = false;

//    protected $casts=['title'=>'json'];
}
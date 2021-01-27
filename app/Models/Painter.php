<?php
/**
 * Created by shaofeng
 * Date: 2020/12/23 11:24
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Painter extends Model
{
    protected $table = 'painter';
    public $timestamps = false;

    public function painting(){
        return $this->hasMany(Painting::class,'painter_id');
    }
}
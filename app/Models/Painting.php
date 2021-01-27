<?php
/**
 * Created by shaofeng
 * Date: 2020/12/23 11:24
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Painting extends Model
{
    protected $table = 'painting';
    public $timestamps = false;

    protected $fillable=['title','body'];

    public function painter(){
        return $this->belongsTo(Painter::class,'painter_id');
    }
}
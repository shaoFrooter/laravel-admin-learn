<?php
/**
 * Created by shaofeng
 * Date: 2020/12/22 19:32
 */

namespace App\Admin\Controllers;


use App\Http\Controllers\Controller;

class BatchUpdateController extends Controller
{
    public function release(Request $request)
    {
        foreach (Post::find($request->get('ids')) as $post) {
            $post->released = $request->get('action');
            $post->save();
        }
    }

}
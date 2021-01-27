<?php
/**
 * Created by shaofeng
 * Date: 2020/12/25 14:39
 */

namespace App\Http\Controllers;




use App\Common\Entity\RuleForm;
use App\Common\Util\EncryptUtil;
use App\Common\Util\JsonUtil;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MyAuthController extends Controller
{

    public function resetPasswordView(){
        return view('auth.passwords.reset1');
    }

    public function doRest(Request $request){
        echo 'hello';
    }

    public function greeting(Request $request){
        $allParam=$request->all();
//        $username=$request->get('username');
//        $encodeString=EncryptUtil::encryptString($username);
//        $decodeString=EncryptUtil::decodeString($encodeString);
        $ruleForm=new RuleForm();
        $ruleForm->name='邵锋';
        $ruleForm->type=[1,2];
        $ruleForm->resource='123';
        $ruleForm->date1=now();
        $ruleForm->date2=now();
        $ruleForm->delivery='123';
        $ruleForm->desc='123';
        Log::info('myAuthController@greeting---allParam='.json_encode($ruleForm));
        return JsonUtil::toJson($ruleForm);
    }

}
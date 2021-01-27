<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\AdminUser;
use App\Providers\RouteServiceProvider;
use App\User;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use function PHPUnit\Framework\isEmpty;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords{
        ResetsPasswords::reset as traitsReset;
    }

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
//    protected $redirectTo = RouteServiceProvider::HOME;
    protected $redirectTo = '/admin/auth/login';

    public function reset(Request $request)
    {
      $resetResponse=$this->traitsReset($request);
      $password=$request->get('password');
      $email=$request->get('email');
      $user=new User();
      $emailUser=$user->newQuery()->where('email',$email)->first();
      if(isEmpty($emailUser)){

      }
      $name=$emailUser['name'];
      $hashPassword=Hash::make($password);
      $adminUser=new AdminUser();
        $adminUser->newQuery()->where('username',$name)->update(['username'=>$name,'password'=>$hashPassword]);
        $adminUser->newQuery()->where('username',$email)->update(['username'=>$email,'password'=>$hashPassword]);
      return $resetResponse;
    }

}

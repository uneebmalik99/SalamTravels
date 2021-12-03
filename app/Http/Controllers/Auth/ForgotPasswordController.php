<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;
    public function showForgetPasswordForm(){
        return view('auth.forgot_password');
    }
    public function submitForgetPassword(Request $request){
        $request->validate([
            'email'=>'required|email|exists:users',
        ]);
        $token = Str::random(64);
        DB::table('password_resets')->insert([
            'email'=>$request->email,
            'token'=>$token,
            'created_at'=>Carbon::now()
        ]);
        require base_path('vendor/autoload.php');
        //require ('../vendor/autoload.php');
        $mail = new PHPMailer(true);
    try{
        $mail->SMTPDebug = 0;
        $mail->isSMTP();
        $mail->Host = 'mail.salamtravels.com.pk';
        $mail->SMTPAuth = true;
        $mail->Username = 'admin@salamtravels.com.pk';
        $mail->Password = 'Salam7879';
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;
        $mail->setFrom('admin@salamtravels.com.pk', 'Salam Travels and Tours');
        $mail->isHTML(true);

        $mail->Subject = 'SALAM WEB PORTAL Reset Password REQUEST';
        $mail->addAddress($request->email);
        $mail->Body = '<h1>Forget Password Email</h1>'.
   
        'You can reset password from this link:'.
        '<a href="'.route('reset.password.get', $token) .'">Reset Password</a>';
        $mail->send();
        return back()->with(['status'=>'We have emailed your password reset link!']);
    }
    catch(Exception $ex)
        {
            return back()->with(['status'=>'please retry your reqest']);
        }
        

    }
    public function showResetPasswordForm($token) { 
        return view('auth.passwords.reset', ['token' => $token]);
     }

     public function submitResetPasswordForm(Request $request)
      {
          $request->validate([
              'email' => 'required|email|exists:users',
              'password' => 'required|string|min:6|confirmed',
              'password_confirmation' => 'required'
          ]);
  
          $updatePassword = DB::table('password_resets')
                              ->where([
                                'email' => $request->email, 
                                'token' => $request->token
                              ])
                              ->first();
  
          if(!$updatePassword){
              return back()->withInput()->with('error', 'Invalid token!');
          }
  
          $user = User::where('email', $request->email)
                      ->update(['password' => Hash::make($request->password)]);
          Customer::where('email', $request->email)
                    ->update(['password'=>$request->password]);
 
          DB::table('password_resets')->where(['email'=> $request->email])->delete();
  
          return redirect('/login')->with('message', 'Your password has been changed!');
      }
}

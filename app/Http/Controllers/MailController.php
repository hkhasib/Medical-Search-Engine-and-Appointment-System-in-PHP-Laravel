<?php

namespace App\Http\Controllers;

use App\Mail\ResetEmail;
use App\Mail\TestMail;
use App\Models\PasswordReset;
use App\Models\UserInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    public function passwordResetMail(Request $request){

        if (UserInfo::where('email','=',$request->email)->first()==null){
            return redirect()->back()->with('error','There is no user with this email address: '.$request->email);
        }
$reset_key=Hash::make(substr(str_shuffle("0123456789abcdefghijklmnopqrstvwxyz"), 0, 16));
PasswordReset::create([
   'user_id'=>UserInfo::where('email','=',$request->email)->value('user_id'),
    'reset_key'=>$reset_key,
    'validity'=>date('Y-m-d H:i:s',time()+3600)
]);
        $details = [
            'title'=>'Reset Your Password',
            'text'=>'Use the Following link to reset',
            'link_text'=>'Reset Now',
            'link'=>'http://getdoc.com/reset-password?u_id='.UserInfo::where('email','=',$request->email)->value('user_id').'&key='.$reset_key
        ];
        Mail::to($request->email)->send(new ResetEmail($details));
        return redirect()->back()->with('success','A Password Reset Link has been Sent to: '.$request->email.' It will expire within next 60 minutes!');
    }
}

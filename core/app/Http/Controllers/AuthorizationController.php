<?php

namespace App\Http\Controllers;

use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;


class AuthorizationController extends Controller
{
    public function __construct()
    {
        return $this->activeTemplate = activeTemplate();
    }

    public function checkValidCode($user, $code, $addMin = 10000)
    {
        if (!$code) return false;
        if (!$user->ver_code_send_at) return false;
        if ($user->ver_code_send_at->addMinutes($addMin) < Carbon::now()) return false;
        if ($user->ver_code !== $code) return false;
        return true;
    }


    public function authorizeForm()
    {
        $user = auth()->user();
        if (!$user->status) {
            Auth::logout();
        }
        if(!$user->ev) {
            $type = 'email';
            $pageTitle = 'Verify Your Email';
            $notifyTemplate = 'EVER_CODE';
        }elseif (!$user->sv) {
            $type = 'sms';
            $pageTitle = 'Verify Your Mobile Number';
            $notifyTemplate = 'SVER_CODE';
        }elseif (!$user->tv) {
            $pageTitle = 'Verify Google 2FA';
            $type = '2fa';
        }else{
            return redirect()->route('user.home');
        }

        if (!$this->checkValidCode($user, $user->ver_code) && ($type != '2fa')) {
            $user->ver_code = verificationCode(6);
            $user->ver_code_send_at = Carbon::now();
            $user->save();
            notify($user, $notifyTemplate, [
                'code' => $user->ver_code
            ],[$type]);
        }

        return view($this->activeTemplate.'user.auth.authorization.'.$type, compact('user', 'pageTitle'));

    }

    public function sendVerifyCode($type)
    {
        $user = Auth::user();

        if ($this->checkValidCode($user, $user->ver_code, 2)) {
            $targetTime = $user->ver_code_send_at->addMinutes(2)->timestamp;
            $delay = $targetTime - time();
            throw ValidationException::withMessages(['resend' => 'Please try after ' . $delay . ' seconds']);
        }

        $user->ver_code = verificationCode(6);
        $user->ver_code_send_at = Carbon::now();
        $user->save();

        if ($type == 'email') {
            $type = 'email';
            $notifyTemplate = 'EVER_CODE';
        } else {
            $type = 'sms';
            $notifyTemplate = 'SVER_CODE';
        }

        notify($user, $notifyTemplate, [
            'code' => $user->ver_code
        ],[$type]);

        $notify[] = ['success', 'Verification code sent successfully'];
        return back()->withNotify($notify);
    }

    public function emailVerification(Request $request)
    {
        $request->validate([
            'code'=>'required'
        ]);


        $emailVerifiedCode = $request->code;
        $user = Auth::user();

        if ($this->checkValidCode($user, $emailVerifiedCode)) {
            $user->ev = 1;
            $user->ver_code = null;
            $user->ver_code_send_at = null;
            $user->save();
            return redirect()->route('user.home');
        }
        throw ValidationException::withMessages(['code' => 'Verification code doesn\'t match!']);
    }

    public function smsVerification(Request $request)
    {
        $request->validate([
            'code' => 'required',
        ]);

        $smsVerifiedCode =  $request->code;

        $user = Auth::user();
        if ($this->checkValidCode($user, $smsVerifiedCode)) {
            $user->sv = 1;
            $user->ver_code = null;
            $user->ver_code_send_at = null;
            $user->save();
            return redirect()->route('user.home');
        }
        throw ValidationException::withMessages(['code' => 'Verification code didn\'t match!']);
    }
    public function g2faVerification(Request $request)
    {
        $user = auth()->user();
        $request->validate([
            'code' => 'required',
        ]);
        $code = $request->code;
        $response = verifyG2fa($user,$code);
        if ($response) {
            return redirect()->route('user.home');
        }
        $notify[] = ['error','Invalid verification code provided'];
        return back()->withNotify($notify);
    }
}

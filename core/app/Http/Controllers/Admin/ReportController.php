<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NotificationLog;
use App\Models\Transaction;
use App\Models\UserLogin;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function transaction()
    {
        $pageTitle = 'Transactions History';
        $transactions = Transaction::with('user')->orderBy('id','desc')->paginate(getPaginate());
        $emptyMessage = 'No transaction found';
        return view('admin.reports.transactions', compact('pageTitle', 'transactions', 'emptyMessage'));
    }

    public function transactionSearch(Request $request)
    {
        $request->validate(['search' => 'required']);
        $search = $request->search;
        $pageTitle = 'Transaction Search Results for "' . $search.'"';
        $emptyMessage = 'No transactions found';

        $transactions = Transaction::with('user')->whereHas('user', function ($user) use ($search) {
            $user->where('username', 'like',"%$search%");
        })->orWhere('trx', $search)->orderBy('id','desc')->paginate(getPaginate());

        return view('admin.reports.transactions', compact('pageTitle', 'transactions', 'emptyMessage','search'));
    }

    public function loginHistory(Request $request)
    {
        if ($request->search) {
            $search = $request->search;
            $pageTitle = 'Login History Search Results for "' . $search.'"';
            $loginLogs = UserLogin::whereHas('user', function ($query) use ($search) {
                $query->where('username', $search);
            })->orderBy('id','desc')->with('user')->paginate(getPaginate());
            return view('admin.reports.logins', compact('pageTitle', 'emptyMessage', 'search', 'loginLogs'));
        }
        $pageTitle = 'User Login History';
        $emptyMessage = 'No login history found';
        $loginLogs = UserLogin::orderBy('id','desc')->with('user')->paginate(getPaginate());
        return view('admin.reports.logins', compact('pageTitle', 'emptyMessage', 'loginLogs'));
    }

    public function loginIpHistory($ip)
    {
        $pageTitle = 'All Logins by - ' . $ip;
        $loginLogs = UserLogin::where('user_ip',$ip)->orderBy('id','desc')->with('user')->paginate(getPaginate());
        $emptyMessage = 'No email sending history found';
        return view('admin.reports.logins', compact('pageTitle', 'emptyMessage', 'loginLogs','ip'));

    }

    public function emailHistory(){
        $pageTitle = 'Email History';
        $logs = NotificationLog::with('user')->where('type','email')->orderBy('id','desc')->paginate(getPaginate());
        $emptyMessage = 'No email sending history found';
        $type = 'email';
        return view('admin.reports.notification_history', compact('pageTitle', 'emptyMessage','logs','type'));
    }

    public function smsHistory(){
        $pageTitle = 'Sms History';
        $logs = NotificationLog::with('user')->where('type','sms')->orderBy('id','desc')->paginate(getPaginate());
        $emptyMessage = 'No sms sending history found';
        $type = 'sms';
        return view('admin.reports.notification_history', compact('pageTitle', 'emptyMessage','logs','type'));
    }

    public function telegramHistory(){
        $pageTitle = 'Telegram History';
        $logs = NotificationLog::with('user')->where('type','telegram')->orderBy('id','desc')->paginate(getPaginate());
        $emptyMessage = 'No telegram sending history found';
        $type = 'telegram';
        return view('admin.reports.notification_history', compact('pageTitle', 'emptyMessage','logs','type'));
    }

    public function emailDetails($id){
        $pageTitle = 'Email Details';
        $email = NotificationLog::findOrFail($id);
        return view('admin.reports.email_details', compact('pageTitle','email'));
    }
}

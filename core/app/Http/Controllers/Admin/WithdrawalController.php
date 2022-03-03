<?php

namespace App\Http\Controllers\Admin;

use App\Models\GeneralSetting;
use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\User;
use App\Models\WithdrawMethod;
use App\Models\Withdrawal;
use Illuminate\Http\Request;

class WithdrawalController extends Controller
{
    public function pending()
    {
        $pageTitle = 'Pending Withdrawals';
        $withdrawals = Withdrawal::pending()->with(['user','method'])->orderBy('id','desc')->paginate(getPaginate());
        $emptyMessage = 'No pending withdrawal found';
        return view('admin.withdraw.withdrawals', compact('pageTitle', 'withdrawals', 'emptyMessage'));
    }

    public function approved()
    {
        $pageTitle = 'Approved Withdrawals';
        $withdrawals = Withdrawal::approved()->with(['user','method'])->orderBy('id','desc')->paginate(getPaginate());
        $emptyMessage = 'No pending withdrawal found';
        return view('admin.withdraw.withdrawals', compact('pageTitle', 'withdrawals', 'emptyMessage'));
    }

    public function rejected()
    {
        $pageTitle = 'Rejected Withdrawals';
        $withdrawals = Withdrawal::rejected()->with(['user','method'])->orderBy('id','desc')->paginate(getPaginate());
        $emptyMessage = 'No pending withdrawal found';
        return view('admin.withdraw.withdrawals', compact('pageTitle', 'withdrawals', 'emptyMessage'));
    }

    public function log()
    {
        $pageTitle = 'All Withdrawals';
        $withdrawals = Withdrawal::where('status', '!=', 0)->with(['user','method'])->orderBy('id','desc')->paginate(getPaginate());
        $emptyMessage = 'No withdrawal found';
        return view('admin.withdraw.withdrawals', compact('pageTitle', 'withdrawals', 'emptyMessage'));
    }


    public function logViaMethod($methodId,$type = null){
        $method = WithdrawMethod::findOrFail($methodId);
        if ($type == 'approved') {
            $pageTitle = 'Approved Withdrawal ';
            $withdrawals = Withdrawal::where('status', 1)->with(['user','method'])->where('method_id',$method->id)->orderBy('id','desc')->paginate(getPaginate());
        }elseif($type == 'rejected'){
            $pageTitle = 'Rejected Withdrawals ';
            $withdrawals = Withdrawal::where('status', 3)->with(['user','method'])->where('method_id',$method->id)->orderBy('id','desc')->paginate(getPaginate());

        }elseif($type == 'pending'){
            $pageTitle = 'Pending Withdrawals ';
            $withdrawals = Withdrawal::where('status', 2)->with(['user','method'])->where('method_id',$method->id)->orderBy('id','desc')->paginate(getPaginate());
        }else{
            $pageTitle = 'All Withdrawals ';
            $withdrawals = Withdrawal::where('status', '!=', 0)->with(['user','method'])->where('method_id',$method->id)->orderBy('id','desc')->paginate(getPaginate());
        }
        $pageTitle .= 'via '.$method->name;
        $emptyMessage = 'No withdrawal found';
        return view('admin.withdraw.withdrawals', compact('pageTitle', 'withdrawals', 'emptyMessage','method'));
    }


    public function search(Request $request, $scope)
    {
        $search = $request->search;
        $emptyMessage = 'No withdrawal found';

        $withdrawals = Withdrawal::with(['user', 'method'])->where('status','!=',0)->where(function ($q) use ($search) {
            $q->where('trx', 'like',"%$search%")
                ->orWhereHas('user', function ($user) use ($search) {
                    $user->where('username', 'like',"%$search%");
                });
        });

        if ($scope == 'pending') {
            $pageTitle = 'Pending Withdrawal ';
            $withdrawals = $withdrawals->where('status', 2);
        }elseif($scope == 'approved'){
            $pageTitle = 'Approved Withdrawal ';
            $withdrawals = $withdrawals->where('status', 1);
        }elseif($scope == 'rejected'){
            $pageTitle = 'Rejected Withdrawal ';
            $withdrawals = $withdrawals->where('status', 3);
        }else{
            $pageTitle = 'Withdrawal History ';
        }

        $withdrawals = $withdrawals->paginate(getPaginate());
        $pageTitle .= ' Search Results for "' . $search.'"';

        return view('admin.withdraw.withdrawals', compact('pageTitle', 'emptyMessage', 'search', 'scope', 'withdrawals'));
    }

    public function details($id)
    {
        $general = GeneralSetting::first();
        $withdrawal = Withdrawal::where('id',$id)->where('status', '!=', 0)->with(['user','method'])->firstOrFail();
        $pageTitle = 'Withdrawal Details';
        $details = $withdrawal->withdraw_information ? json_encode($withdrawal->withdraw_information) : null;
        return view('admin.withdraw.detail', compact('pageTitle', 'withdrawal','details'));
    }

    public function approve(Request $request)
    {
        $request->validate(['id' => 'required|integer']);
        $withdraw = Withdrawal::where('id',$request->id)->where('status',2)->with('user')->firstOrFail();
        $withdraw->status = 1;
        $withdraw->admin_feedback = $request->details;
        $withdraw->save();

        $general = GeneralSetting::first();
        notify($withdraw->user, 'WITHDRAW_APPROVE', [
            'method_name' => $withdraw->method->name,
            'method_currency' => $withdraw->currency,
            'method_amount' => showAmount($withdraw->final_amount),
            'amount' => showAmount($withdraw->amount),
            'charge' => showAmount($withdraw->charge),
            'currency' => $general->cur_text,
            'rate' => showAmount($withdraw->rate),
            'trx' => $withdraw->trx,
            'admin_details' => $request->details
        ]);

        $notify[] = ['success', 'Withdrawal request approved successfully'];
        return redirect()->route('admin.withdraw.pending')->withNotify($notify);
    }


    public function reject(Request $request)
    {
        $general = GeneralSetting::first();
        $request->validate(['id' => 'required|integer']);
        $withdraw = Withdrawal::where('id',$request->id)->where('status',2)->firstOrFail();

        $withdraw->status = 3;
        $withdraw->admin_feedback = $request->details;
        $withdraw->save();

        $user = User::find($withdraw->user_id);
        $user->balance += $withdraw->amount;
        $user->save();



            $transaction = new Transaction();
            $transaction->user_id = $withdraw->user_id;
            $transaction->amount = $withdraw->amount;
            $transaction->post_balance = $user->balance;
            $transaction->charge = 0;
            $transaction->trx_type = '+';
            $transaction->details = showAmount($withdraw->amount) . ' ' . $general->cur_text . ' Refunded from withdrawal rejection';
            $transaction->trx = $withdraw->trx;
            $transaction->save();




        notify($user, 'WITHDRAW_REJECT', [
            'method_name' => $withdraw->method->name,
            'method_currency' => $withdraw->currency,
            'method_amount' => showAmount($withdraw->final_amount),
            'amount' => showAmount($withdraw->amount),
            'charge' => showAmount($withdraw->charge),
            'currency' => $general->cur_text,
            'rate' => showAmount($withdraw->rate),
            'trx' => $withdraw->trx,
            'post_balance' => showAmount($user->balance),
            'rejection_message' => $request->details
        ]);

        $notify[] = ['success', 'Withdrawal request rejected successfully'];
        return redirect()->route('admin.withdraw.pending')->withNotify($notify);
    }

}
